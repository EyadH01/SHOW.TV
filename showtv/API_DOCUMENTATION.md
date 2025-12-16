# SHOW.TV - API Documentation

## 📚 جدول المحتويات
1. [Authentication](#authentication)
2. [Playlists API](#playlists-api)
3. [Episodes API](#episodes-api)
4. [Shows API](#shows-api)
5. [Shahed API](#shahed-api)
6. [Roya API](#roya-api)

---

## Authentication

جميع الـ API endpoints المحمية تتطلب مصادقة المستخدم.

### Login
```http
POST /login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### Register
```http
POST /register
Content-Type: application/json

{
    "name": "User Name",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

---

## Playlists API

### Get All Playlists
```http
GET /playlists
Authorization: Bearer {token}
```

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "name": "My Favorite Shows",
            "description": "Collection of my favorite series",
            "episodes_count": 15,
            "created_at": "2025-12-16T10:00:00Z",
            "updated_at": "2025-12-16T10:00:00Z"
        }
    ]
}
```

### Create Playlist
```http
POST /playlists
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "My Playlist",
    "description": "Optional description"
}
```

**Response:**
```json
{
    "id": 1,
    "user_id": 1,
    "name": "My Playlist",
    "description": "Optional description",
    "created_at": "2025-12-16T10:00:00Z",
    "updated_at": "2025-12-16T10:00:00Z"
}
```

### Get Playlist Details
```http
GET /playlists/{id}
Authorization: Bearer {token}
```

**Response:**
```json
{
    "id": 1,
    "user_id": 1,
    "name": "My Playlist",
    "description": "Optional description",
    "episodes": [
        {
            "id": 1,
            "title": "Episode 1",
            "description": "First episode",
            "duration": 45,
            "thumbnail": "https://...",
            "video_url": "https://...",
            "airing_time": "Monday 8:30 PM"
        }
    ],
    "created_at": "2025-12-16T10:00:00Z",
    "updated_at": "2025-12-16T10:00:00Z"
}
```

### Update Playlist
```http
PUT /playlists/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "name": "Updated Name",
    "description": "Updated description"
}
```

### Delete Playlist
```http
DELETE /playlists/{id}
Authorization: Bearer {token}
```

### Add Episode to Playlist
```http
POST /playlists/{playlist_id}/episodes
Authorization: Bearer {token}
Content-Type: application/json

{
    "episode_id": 1
}
```

### Remove Episode from Playlist
```http
DELETE /playlists/{playlist_id}/episodes/{episode_id}
Authorization: Bearer {token}
```

---

## Episodes API

### Get All Episodes
```http
GET /episodes
```

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 15)
- `show_id` - Filter by show ID
- `search` - Search by title

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "show_id": 1,
            "title": "Episode 1",
            "description": "First episode description",
            "duration": 45,
            "airing_time": "Monday 8:30 PM",
            "thumbnail": "https://...",
            "video_url": "https://...",
            "youtube_video_id": "dQw4w9WgXcQ",
            "likes": 100,
            "dislikes": 5,
            "created_at": "2025-12-16T10:00:00Z"
        }
    ],
    "pagination": {
        "total": 100,
        "per_page": 15,
        "current_page": 1,
        "last_page": 7
    }
}
```

### Get Episode Details
```http
GET /episodes/{id}
```

**Response:**
```json
{
    "id": 1,
    "show_id": 1,
    "show": {
        "id": 1,
        "title": "Show Title",
        "description": "Show description",
        "poster": "https://...",
        "wallpaper": "https://..."
    },
    "title": "Episode 1",
    "description": "First episode description",
    "duration": 45,
    "airing_time": "Monday 8:30 PM",
    "thumbnail": "https://...",
    "video_url": "https://...",
    "youtube_video_id": "dQw4w9WgXcQ",
    "likes": 100,
    "dislikes": 5,
    "user_like_status": "like", // or "dislike" or null
    "created_at": "2025-12-16T10:00:00Z"
}
```

### Like Episode
```http
POST /episodes/{id}/like
Authorization: Bearer {token}
```

### Dislike Episode
```http
POST /episodes/{id}/dislike
Authorization: Bearer {token}
```

### Remove Like/Dislike
```http
DELETE /episodes/{id}/like
Authorization: Bearer {token}
```

---

## Shows API

### Get All Shows
```http
GET /shows
```

**Query Parameters:**
- `page` - Page number (default: 1)
- `per_page` - Items per page (default: 12)
- `search` - Search by title
- `category` - Filter by category

**Response:**
```json
{
    "data": [
        {
            "id": 1,
            "title": "Show Title",
            "description": "Show description",
            "airing_time": "Monday-Thursday @ 8:30 PM",
            "poster": "https://...",
            "wallpaper": "https://...",
            "episodes_count": 50,
            "followers_count": 1000,
            "is_following": false,
            "created_at": "2025-12-16T10:00:00Z"
        }
    ],
    "pagination": {
        "total": 50,
        "per_page": 12,
        "current_page": 1,
        "last_page": 5
    }
}
```

### Get Show Details
```http
GET /shows/{id}
```

**Response:**
```json
{
    "id": 1,
    "title": "Show Title",
    "description": "Show description",
    "airing_time": "Monday-Thursday @ 8:30 PM",
    "poster": "https://...",
    "wallpaper": "https://...",
    "episodes": [
        {
            "id": 1,
            "title": "Episode 1",
            "description": "First episode",
            "duration": 45,
            "thumbnail": "https://...",
            "airing_time": "Monday 8:30 PM"
        }
    ],
    "followers_count": 1000,
    "is_following": false,
    "created_at": "2025-12-16T10:00:00Z"
}
```

### Follow Show
```http
POST /shows/{id}/follow
Authorization: Bearer {token}
```

### Unfollow Show
```http
DELETE /shows/{id}/follow
Authorization: Bearer {token}
```

---

## Shahed API

### Search Shows
```http
GET /admin/shahed/search?q=مسلسل
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "results": [
        {
            "id": "123",
            "title": "اسم المسلسل",
            "description": "الوصف",
            "poster": "https://...",
            "wallpaper": "https://...",
            "episodes_count": 50
        }
    ]
}
```

### Import Show from Shahed
```http
POST /admin/shahed/import
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "shahed_id": "123",
    "title": "اسم المسلسل",
    "description": "الوصف",
    "poster": "https://...",
    "wallpaper": "https://..."
}
```

### Get Shahed Episodes
```http
GET /admin/shahed/episodes?show_id=123
Authorization: Bearer {admin_token}
```

### Import Episode from Shahed
```http
POST /admin/shahed/episodes/import
Authorization: Bearer {admin_token}
Content-Type: application/json

{
    "show_id": 1,
    "title": "اسم الحلقة",
    "description": "الوصف",
    "duration": 45,
    "airing_time": "الجمعة 8:30 مساءً",
    "thumbnail": "https://...",
    "video_url": "https://..."
}
```

---

## Roya API

### Get Roya Videos
```http
GET /admin/roya/videos
Authorization: Bearer {admin_token}
```

**Response:**
```json
{
    "videos": [
        {
            "id": "dQw4w9WgXcQ",
            "title": "اسم الفيديو",
            "description": "الوصف",
            "thumbnail": "https://...",
            "duration": 2700,
            "published_at": "2025-12-16T10:00:00Z"
        }
    ]
}
```

### Search Roya Videos
```http
GET /admin/roya/search?q=مسلسل
Authorization: Bearer {admin_token}
```

### Sync Roya Videos
```http
POST /admin/roya/sync
Authorization: Bearer {admin_token}
```

---

## Error Responses

### 400 Bad Request
```json
{
    "error": "Validation failed",
    "messages": {
        "name": ["The name field is required"]
    }
}
```

### 401 Unauthorized
```json
{
    "error": "Unauthorized",
    "message": "Please login first"
}
```

### 403 Forbidden
```json
{
    "error": "Forbidden",
    "message": "You don't have permission to access this resource"
}
```

### 404 Not Found
```json
{
    "error": "Not found",
    "message": "The requested resource was not found"
}
```

### 500 Server Error
```json
{
    "error": "Server error",
    "message": "An unexpected error occurred"
}
```

---

## Rate Limiting

- **Limit:** 60 requests per minute per IP
- **Headers:**
  - `X-RateLimit-Limit: 60`
  - `X-RateLimit-Remaining: 59`
  - `X-RateLimit-Reset: 1640000000`

---

## Pagination

جميع الـ list endpoints تدعم الـ pagination:

```json
{
    "data": [...],
    "pagination": {
        "total": 100,
        "per_page": 15,
        "current_page": 1,
        "last_page": 7,
        "from": 1,
        "to": 15
    }
}
```

---

## Filtering & Sorting

### Filtering
```http
GET /episodes?show_id=1&duration=45
```

### Sorting
```http
GET /episodes?sort=created_at&order=desc
```

---

## Examples

### Create a Playlist and Add Episodes
```bash
# 1. Create playlist
curl -X POST http://localhost:8000/playlists \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "My Favorites",
    "description": "My favorite episodes"
  }'

# 2. Add episode to playlist
curl -X POST http://localhost:8000/playlists/1/episodes \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "episode_id": 1
  }'

# 3. Get playlist with episodes
curl http://localhost:8000/playlists/1 \
  -H "Authorization: Bearer {token}"
```

### Search and Import from Shahed
```bash
# 1. Search for shows
curl "http://localhost:8000/admin/shahed/search?q=مسلسل" \
  -H "Authorization: Bearer {admin_token}"

# 2. Import show
curl -X POST http://localhost:8000/admin/shahed/import \
  -H "Authorization: Bearer {admin_token}" \
  -H "Content-Type: application/json" \
  -d '{
    "shahed_id": "123",
    "title": "اسم المسلسل",
    "description": "الوصف",
    "poster": "https://...",
    "wallpaper": "https://..."
  }'
```

---

## Webhooks (Coming Soon)

- Episode published
- Show followed
- Episode liked
- Playlist created

---

**آخر تحديث:** 16 ديسمبر 2025
**الإصدار:** 2.0.0
