<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Laravel\Socialite\Two\User as GoogleUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_redirect_sends_user_to_google_oauth(): void
    {
        $this->configureGoogleOAuth();

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('redirect')
            ->once()
            ->andReturn(redirect()->away('https://accounts.google.com/o/oauth2/auth'));

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);

        $this->get(route('auth.google.redirect'))
            ->assertRedirect('https://accounts.google.com/o/oauth2/auth');
    }

    public function test_verified_google_user_can_create_an_account_and_sign_in(): void
    {
        $this->configureGoogleOAuth();
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-user-100',
            'name' => 'Amina Diallo',
            'email' => 'AMINA@example.com',
            'email_verified' => true,
        ]));

        $response = $this->get(route('auth.google.callback'));

        $response
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'Amina Diallo',
            'email' => 'amina@example.com',
            'google_id' => 'google-user-100',
            'role' => 'student',
            'is_active' => true,
        ]);
        $this->assertAuthenticated();
    }

    public function test_verified_google_user_is_linked_to_existing_account_without_changing_role(): void
    {
        $this->configureGoogleOAuth();
        $admin = User::factory()->create([
            'name' => 'AfriCode Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'google_id' => null,
        ]);
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-admin-200',
            'email' => 'ADMIN@example.com',
            'email_verified' => true,
        ]));

        $response = $this->get(route('auth.google.callback'));

        $response->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'email' => 'admin@example.com',
            'google_id' => 'google-admin-200',
            'role' => 'admin',
        ]);
        $this->assertAuthenticatedAs($admin);
    }

    public function test_google_cannot_be_linked_to_an_existing_unverified_account(): void
    {
        $this->configureGoogleOAuth();
        $user = User::factory()->unverified()->create([
            'email' => 'unverified-local@example.com',
        ]);
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-user-unverified-link',
            'email' => $user->email,
            'email_verified' => true,
        ]));

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'google_id' => 'google-user-unverified-link',
        ]);
        $this->assertGuest();
    }

    public function test_google_cannot_grant_administrator_role_to_a_new_account(): void
    {
        $this->configureGoogleOAuth();
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-admin-email-new',
            'email' => 'seydoubakhayokho1@gmail.com',
            'email_verified' => true,
        ]));

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'seydoubakhayokho1@gmail.com',
            'role' => 'student',
        ]);
    }

    public function test_unverified_google_email_is_rejected_without_creating_an_account(): void
    {
        $this->configureGoogleOAuth();
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-user-unverified',
            'email' => 'unverified@example.com',
            'email_verified' => false,
        ]));

        $response = $this->get(route('auth.google.callback'));

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertDatabaseMissing('users', [
            'email' => 'unverified@example.com',
        ]);
        $this->assertGuest();
    }

    public function test_disabled_account_cannot_sign_in_with_google(): void
    {
        $this->configureGoogleOAuth();
        User::factory()->create([
            'email' => 'disabled@example.com',
            'is_active' => false,
        ]);
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-user-disabled',
            'email' => 'disabled@example.com',
            'email_verified' => true,
        ]));

        $response = $this->get(route('auth.google.callback'));

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertDatabaseMissing('users', [
            'email' => 'disabled@example.com',
            'google_id' => 'google-user-disabled',
        ]);
        $this->assertGuest();
    }

    public function test_invalid_google_oauth_state_returns_user_to_login(): void
    {
        $this->configureGoogleOAuth();
        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')
            ->once()
            ->andThrow(new InvalidStateException);

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);

        $this->get(route('auth.google.callback'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertGuest();
    }

    public function test_google_sign_in_reports_missing_credentials(): void
    {
        config([
            'services.google.client_id' => null,
            'services.google.client_secret' => null,
            'services.google.redirect' => null,
        ]);

        $this->get(route('auth.google.redirect'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');
    }

    public function test_google_sign_in_button_is_available_on_login_and_registration_pages(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Continuer avec Google');

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Continuer avec Google');
    }

    public function test_google_cancellation_returns_user_to_login_with_a_message(): void
    {
        $this->get(route('auth.google.callback', ['error' => 'access_denied']))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertGuest();
    }

    public function test_google_identity_cannot_be_linked_to_an_account_already_linked_elsewhere(): void
    {
        $this->configureGoogleOAuth();
        User::factory()->create([
            'email' => 'linked@example.com',
            'google_id' => 'another-google-user',
        ]);
        $this->mockGoogleUser(GoogleUser::fake([
            'id' => 'google-user-conflict',
            'email' => 'linked@example.com',
            'email_verified' => true,
        ]));

        $response = $this->get(route('auth.google.callback'));

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertDatabaseMissing('users', [
            'email' => 'linked@example.com',
            'google_id' => 'google-user-conflict',
        ]);
        $this->assertGuest();
    }

    private function configureGoogleOAuth(): void
    {
        config([
            'services.google.client_id' => 'test-google-client-id',
            'services.google.client_secret' => 'test-google-client-secret',
            'services.google.redirect' => 'http://localhost/auth/google/callback',
        ]);
    }

    private function mockGoogleUser(GoogleUser $googleUser): void
    {
        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')
            ->once()
            ->andReturn($googleUser);

        Socialite::shouldReceive('driver')
            ->once()
            ->with('google')
            ->andReturn($provider);
    }
}
