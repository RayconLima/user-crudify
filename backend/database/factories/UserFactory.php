<?php

namespace Database\Factories;

use App\Helpers\MinioHelper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $avatarPath = $this->createAvatar();

        return [
            'iti'               => mt_rand(10000000000, 99999999999),
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'profile_photo_path' => $avatarPath,
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    protected function createAvatar(): string
    {
        $imageUrl = "https://avatar.iran.liara.run/public";
        $filename = Str::random(10) . '.jpg';

        $path = 'avatars/' . $filename;

        $imageContent = file_get_contents($imageUrl);
        Storage::disk('s3')->put($path, $imageContent);

        return MinioHelper::generateMinioUrl($path);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}