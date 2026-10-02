<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class AuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_reset_rejects_an_invalid_token_without_changing_the_password(): void
    {
        $user = User::factory()->create([
            'password' => Hash::make('OriginalPass123!'),
        ]);

        $response = $this->post(route('password.update'), [
            'token' => 'forged-token',
            'email' => $user->email,
            'password' => 'AttackerPass123!',
            'password_confirmation' => 'AttackerPass123!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check('OriginalPass123!', $user->fresh()->password));
    }

    public function test_password_reset_accepts_a_valid_token_and_changes_the_password(): void
    {
        config(['session.driver' => 'database']);
        $user = User::factory()->create([
            'password' => Hash::make('OriginalPass123!'),
        ]);
        DB::table('sessions')->insert([
            'id' => 'password-reset-session',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Feature test',
            'payload' => '',
            'last_activity' => now()->timestamp,
        ]);
        $token = Password::createToken($user);
        $oldRememberToken = $user->remember_token;

        $response = $this->post(route('password.update'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'NewSecurePass123!',
            'password_confirmation' => 'NewSecurePass123!',
        ]);

        $response
            ->assertRedirectToRoute('login')
            ->assertSessionHas('success');
        $this->assertTrue(Hash::check('NewSecurePass123!', $user->fresh()->password));
        $this->assertNotSame($oldRememberToken, $user->fresh()->remember_token);
        $this->assertDatabaseMissing('sessions', ['id' => 'password-reset-session']);
    }

    public function test_password_reset_link_is_sent_without_disclosing_unknown_accounts(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('status', 'Si cette adresse e-mail correspond à un compte, un lien de réinitialisation vous a été envoyé.');

        Notification::assertSentTo($user, ResetPassword::class);

        $this->post(route('password.email'), ['email' => 'unknown@example.com'])
            ->assertSessionHas('status', 'Si cette adresse e-mail correspond à un compte, un lien de réinitialisation vous a été envoyé.');
    }

    public function test_registration_requires_email_verification_before_accessing_the_dashboard(): void
    {
        Notification::fake();

        $response = $this->post(route('register'), [
            'name' => 'New Member',
            'email' => 'new-member@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
        ]);
        $user = User::where('email', 'new-member@example.com')->firstOrFail();

        $response->assertRedirectToRoute('verification.notice');
        Notification::assertSentTo($user, VerifyEmail::class);

        $this->get(route('dashboard'))
            ->assertRedirectToRoute('verification.notice');
    }

    public function test_signed_verification_link_verifies_email_and_allows_dashboard_access(): void
    {
        $user = User::factory()->unverified()->create();
        $this->assertTrue($user->is_active);
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ],
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertRedirectToRoute('dashboard')
            ->assertSessionHas('success');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    public function test_signed_verification_link_cannot_verify_another_users_email(): void
    {
        $authenticatedUser = User::factory()->unverified()->create();
        $otherUser = User::factory()->unverified()->create();
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            [
                'id' => $otherUser->id,
                'hash' => sha1($otherUser->getEmailForVerification()),
            ],
        );

        $this->actingAs($authenticatedUser)
            ->get($verificationUrl)
            ->assertForbidden();

        $this->assertNull($otherUser->fresh()->email_verified_at);
    }

    public function test_disabled_account_is_logged_out_and_cannot_access_protected_routes(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_admin_deactivation_rotates_remember_token_and_revokes_database_sessions(): void
    {
        config(['session.driver' => 'database']);

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();
        $this->assertTrue($admin->is_active);
        $oldRememberToken = $user->remember_token;

        DB::table('sessions')->insert([
            'id' => 'revoked-session',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Feature test',
            'payload' => '',
            'last_activity' => now()->timestamp,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.users.status', $user->id))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'is_active' => false,
        ]);
        $this->assertNotSame($oldRememberToken, $user->fresh()->remember_token);
        $this->assertDatabaseMissing('sessions', ['id' => 'revoked-session']);

        $this->actingAs($user->fresh())
            ->get(route('dashboard'))
            ->assertRedirectToRoute('login')
            ->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_database_seeder_does_not_create_a_default_administrator(): void
    {
        config([
            'admin.bootstrap.name' => null,
            'admin.bootstrap.email' => null,
            'admin.bootstrap.password' => null,
        ]);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseMissing('users', [
            'email' => 'seydoubakhayokho1@gmail.com',
        ]);
    }

    public function test_database_seeder_can_provision_an_admin_from_explicit_credentials(): void
    {
        config([
            'admin.bootstrap.name' => 'Provisioned Admin',
            'admin.bootstrap.email' => 'provisioned-admin@example.com',
            'admin.bootstrap.password' => 'OneTimeSecurePass123!',
        ]);

        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', 'provisioned-admin@example.com')->firstOrFail();
        $this->assertSame('admin', $admin->role);
        $this->assertTrue(Hash::check('OneTimeSecurePass123!', $admin->password));
        $this->assertNotNull($admin->email_verified_at);
    }

    public function test_database_seeder_does_not_promote_an_existing_non_admin_account(): void
    {
        config([
            'admin.bootstrap.email' => 'existing-member@example.com',
            'admin.bootstrap.password' => 'OneTimeSecurePass123!',
        ]);
        $user = User::factory()->create([
            'email' => 'existing-member@example.com',
            'role' => 'student',
        ]);

        $this->seed(DatabaseSeeder::class);

        $this->assertSame('student', $user->fresh()->role);
    }

    public function test_public_pages_include_browser_security_headers(): void
    {
        $this->get(route('home'))
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('X-Frame-Options', 'SAMEORIGIN')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin')
            ->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
    }
}
