<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
  public const ROLE_ADMIN = 'ADMIN';
  public const ROLE_EDITOR = 'EDITOR';
  public const ROLE_USER = 'USER';
  public const ROLE_DEFAULT = self::ROLE_USER;

  public const ROLES = [
    self::ROLE_ADMIN => 'Admin',
    self::ROLE_EDITOR => 'Editor',
    self::ROLE_USER => 'User',
  ];

  public function canAccessPanel(Panel $panel): bool
  {
    return $this->can('view-admin', User::class);
  }

  public function isAdmin(): bool
  {
    return $this->role === self::ROLE_ADMIN;
  }

  public function isEditor(): bool
  {
    return $this->role === self::ROLE_EDITOR;
  }

  /** @use HasFactory<\Database\Factories\UserFactory> */
  use HasApiTokens,
    HasFactory,
    HasProfilePhoto,
    Notifiable,
    TwoFactorAuthenticatable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'password',
    'role',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array<int, string>
   */
  protected $appends = [
    'profile_photo_url',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function posts()
  {
    return $this->hasMany(Post::class);
  }

  public function likes()
  {
    return $this->belongsToMany(Post::class, 'post_like')->withTimestamps();
  }

  public function hasLiked(Post $post): bool
  {
    return $this->likes()->where('post_id', $post->id)->exists();
  }

  public function comments()
  {
    return $this->hasMany(PostComment::class);
  }
}
