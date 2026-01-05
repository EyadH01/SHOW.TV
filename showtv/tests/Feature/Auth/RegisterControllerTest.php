<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp(): void
    {
        parent::setUp();
        
        // Reset storage for each test
        Storage::fake('public');
    }

    /**
     * Test registration form is accessible
     */
    public function test_registration_page_loads()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test user can register with valid data
     */
    public function test_user_can_register_with_valid_data()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs(User::where('email', 'testuser@example.com')->first());
    }

    /**
     * Test registration with image upload
     */
    public function test_user_can_register_with_image()
    {
        // Skip if GD extension not available for image factory
        if (!extension_loaded('gd')) {
            $this->markTestSkipped('GD extension required for image tests');
        }

        $file = UploadedFile::fake()->image('profile.jpg', 500, 500);

        $response = $this->post('/register', [
            'name' => 'User With Image',
            'email' => 'imaguser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'image' => $file,
        ]);

        $user = User::where('email', 'imaguser@example.com')->first();
        $this->assertNotNull($user->image);
        $this->assertTrue(Storage::disk('public')->exists($user->image));

        $response->assertRedirect();
    }

    /**
     * Test validation: email must be unique
     */
    public function test_registration_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'name' => 'Another User',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertEquals(1, User::where('email', 'existing@example.com')->count());
    }

    /**
     * Test validation: password must be at least 8 characters
     */
    public function test_registration_fails_with_short_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test validation: password confirmation must match
     */
    public function test_registration_fails_with_mismatched_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different456',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test validation: name is required
     */
    public function test_registration_fails_without_name()
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('name');
    }

    /**
     * Test validation: email is required
     */
    public function test_registration_fails_without_email()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Test validation: password is required
     */
    public function test_registration_fails_without_password()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test registration with invalid image type
     */
    public function test_registration_fails_with_invalid_image_type()
    {
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
    }

    /**
     * Test authentication is required to view register page for authenticated users
     */
    public function test_authenticated_users_cannot_access_register()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');
        $response->assertRedirect();
    }

    /**
     * Test user is authenticated after registration
     */
    public function test_user_is_authenticated_after_registration()
    {
        $response = $this->post('/register', [
            'name' => 'Auth Test User',
            'email' => 'auth@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertNotNull(auth()->user());
        $this->assertEquals('auth@example.com', auth()->user()->email);
    }

    /**
     * Test user preferences are created after registration
     */
    public function test_user_preferences_created_after_registration()
    {
        $this->post('/register', [
            'name' => 'Preference Test User',
            'email' => 'pref@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'pref@example.com')->first();
        $this->assertNotNull($user);
        
        // Note: This test assumes UserPreference model relationship exists
        if (method_exists($user, 'userPreference')) {
            $this->assertNotNull($user->userPreference);
        }
    }

    /**
     * Test image is optional during registration
     */
    public function test_registration_succeeds_without_image()
    {
        $response = $this->post('/register', [
            'name' => 'No Image User',
            'email' => 'noimage@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $user = User::where('email', 'noimage@example.com')->first();
        $this->assertNull($user->image);
        $response->assertRedirect();
    }
}
