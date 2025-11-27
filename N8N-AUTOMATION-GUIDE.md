# n8n Automation Guide for Majelis.info

## Overview

Panduan lengkap untuk setup dan konfigurasi n8n workflows untuk automatisasi konten Majelis.info.

## Table of Contents

1. [Setup n8n](#setup-n8n)
2. [WordPress Integration](#wordpress-integration)
3. [Workflow 1: Article → Social Media](#workflow-1-article-to-social-media)
4. [Workflow 2: Article → Short Video](#workflow-2-article-to-short-video)
5. [Workflow 3: Event Reminders](#workflow-3-event-reminders)
6. [Security & Best Practices](#security--best-practices)

---

## Setup n8n

### Opsi 1: n8n Cloud (Recommended untuk mulai)

**Kelebihan:**
- Setup instant, no maintenance
- Auto-scaling
- Managed backups
- Support official

**Harga:**
- Starter: $20/month (5,000 workflows executions)
- Pro: $50/month (10,000 executions)

**Setup:**
1. Daftar di https://n8n.io/cloud
2. Create new workspace
3. Note down your instance URL (e.g., `https://yourname.app.n8n.cloud`)

### Opsi 2: Self-Hosted (VPS)

**Kelebihan:**
- Unlimited executions
- Full control
- Biaya lebih murah untuk high volume

**Requirements:**
- VPS dengan min 2GB RAM
- Docker installed

**Setup via Docker:**

```bash
# Create docker-compose.yml
cat > docker-compose.yml <<EOF
version: '3.8'

services:
  n8n:
    image: n8nio/n8n:latest
    restart: unless-stopped
    ports:
      - "5678:5678"
    environment:
      - N8N_BASIC_AUTH_ACTIVE=true
      - N8N_BASIC_AUTH_USER=admin
      - N8N_BASIC_AUTH_PASSWORD=your_secure_password
      - N8N_HOST=n8n.yourdomain.com
      - N8N_PORT=5678
      - N8N_PROTOCOL=https
      - NODE_ENV=production
      - WEBHOOK_URL=https://n8n.yourdomain.com/
      - GENERIC_TIMEZONE=Asia/Jakarta
    volumes:
      - ./n8n_data:/home/node/.n8n
EOF

# Start n8n
docker-compose up -d

# Check logs
docker-compose logs -f
```

Access: `http://your-vps-ip:5678`

### Opsi 3: Self-Hosted (Hostinger VPS)

Jika Anda sudah punya VPS Hostinger:

```bash
# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose

# Setup n8n (use steps from Opsi 2)
```

---

## WordPress Integration

### Step 1: Configure WordPress API Keys

Tambahkan ke `wp-config.php`:

```php
// Majelis Automation API Keys
define( 'MAJELIS_API_KEY', 'your-random-api-key-here' ); // Generate: openssl rand -hex 32
define( 'MAJELIS_WEBHOOK_SECRET', 'your-webhook-secret-here' ); // Generate: openssl rand -hex 32
```

Atau via WordPress admin, tambahkan options:

```php
update_option( 'majelis_api_key', 'your-api-key' );
update_option( 'majelis_webhook_secret', 'your-secret' );
update_option( 'majelis_n8n_webhook_url', 'https://n8n.yourdomain.com/webhook/majelis' );
```

### Step 2: Test API Endpoints

```bash
# Test webhook endpoint
curl -X POST https://majelis.info/wp-json/majelis/v1/webhooks/n8n \
  -H "Content-Type: application/json" \
  -H "X-Majelis-Signature: YOUR_SIGNATURE" \
  -d '{"action":"test","message":"Hello from n8n"}'

# Test automation status
curl https://majelis.info/wp-json/majelis/v1/automation/status \
  -H "X-Majelis-API-Key: YOUR_API_KEY"
```

### Step 3: Configure Cron Jobs

Di Hostinger cPanel → Cron Jobs:

```bash
# Process automation queue every 5 minutes
*/5 * * * * php /home/user/majelis.info/scripts/process-automation-queue.php >> /home/user/logs/automation.log 2>&1

# Send event reminders daily at 9 AM
0 9 * * * php /home/user/majelis.info/scripts/event-reminders.php >> /home/user/logs/reminders.log 2>&1
```

---

## Workflow 1: Article → Social Media

### Deskripsi
Otomatis posting artikel baru ke Twitter, Facebook, dan Instagram.

### n8n Workflow Structure

```
┌─────────────────────┐
│ 1. Webhook Trigger  │ ← WordPress sends event
└──────────┬──────────┘
           │
┌──────────▼──────────┐
│ 2. Parse Event Data │
└──────────┬──────────┘
           │
┌──────────▼──────────────┐
│ 3. Get Full Article    │ ← HTTP Request to WP API
└──────────┬──────────────┘
           │
┌──────────▼──────────────┐
│ 4. Extract Key Info     │
│   - Title               │
│   - Excerpt             │
│   - Image               │
│   - URL                 │
└──────────┬──────────────┘
           │
           ├─────────────┬──────────────┐
           │             │              │
┌──────────▼──────┐ ┌───▼────────┐ ┌──▼──────────┐
│ 5a. Twitter API │ │ 5b. FB API │ │ 5c. IG API  │
│                 │ │            │ │             │
│ • Format: 280ch │ │ • Add link │ │ • Reformat  │
│ • Add hashtags  │ │ • Hashtags │ │ • Caption   │
│ • Post tweet    │ │ • Post     │ │ • Post      │
└─────────────────┘ └────────────┘ └─────────────┘
```

### n8n Nodes Configuration

#### 1. Webhook Trigger

```json
{
  "name": "WordPress Event Webhook",
  "type": "n8n-nodes-base.webhook",
  "typeVersion": 1,
  "position": [250, 300],
  "webhookId": "majelis-event-published",
  "parameters": {
    "path": "majelis",
    "responseMode": "responseNode",
    "options": {}
  }
}
```

#### 2. HTTP Request - Get Article

```json
{
  "name": "Get WordPress Article",
  "type": "n8n-nodes-base.httpRequest",
  "typeVersion": 3,
  "position": [450, 300],
  "parameters": {
    "url": "={{ $json.body.url }}",
    "authentication": "predefinedCredentialType",
    "nodeCredentialType": "wordpressApi",
    "options": {}
  }
}
```

#### 3. Code Node - Format for Twitter

```javascript
// Extract and format data for Twitter
const title = $json.title.rendered;
const url = $json.link;
const excerpt = $json.excerpt.rendered.replace(/<[^>]*>/g, '').substring(0, 200);

// Create tweet (max 280 characters)
let tweet = `${title}\n\n${url}`;

// Add hashtags
const hashtags = ['#IslamicEvents', '#Kajian', '#MajelisIlmu'];
const hashtagStr = hashtags.join(' ');

if ((tweet + '\n\n' + hashtagStr).length <= 280) {
  tweet += '\n\n' + hashtagStr;
}

return {
  json: {
    text: tweet,
    url: url
  }
};
```

#### 4. Twitter Node

```json
{
  "name": "Post to Twitter",
  "type": "n8n-nodes-base.twitter",
  "typeVersion": 1,
  "position": [650, 200],
  "parameters": {
    "operation": "tweet",
    "text": "={{ $json.text }}"
  },
  "credentials": {
    "twitterOAuth1Api": {
      "id": "1",
      "name": "Twitter Account"
    }
  }
}
```

#### 5. Code Node - Format for Facebook

```javascript
// Format for Facebook
const title = $json.title.rendered;
const url = $json.link;
const excerpt = $json.excerpt.rendered.replace(/<[^>]*>/g, '');
const image = $json.featured_media_url;

const message = `${title}\n\n${excerpt}\n\nSelengkapnya: ${url}\n\n#IslamicEvents #Kajian #MajelisIlmu`;

return {
  json: {
    message: message,
    link: url,
    picture: image
  }
};
```

#### 6. Facebook Node

```json
{
  "name": "Post to Facebook",
  "type": "n8n-nodes-base.facebook",
  "typeVersion": 1,
  "position": [650, 300],
  "parameters": {
    "operation": "post",
    "message": "={{ $json.message }}",
    "link": "={{ $json.link }}"
  }
}
```

### Setup Social Media Credentials in n8n

**Twitter:**
1. Go to https://developer.twitter.com/
2. Create app, get API keys
3. In n8n: Credentials → Add Credential → Twitter OAuth1
4. Input: Consumer Key, Consumer Secret, Access Token, Access Token Secret

**Facebook:**
1. Go to https://developers.facebook.com/
2. Create app, get Page Access Token
3. In n8n: Credentials → Add Credential → Facebook Graph API
4. Input: Access Token

**Instagram:**
- Requires Facebook Business account
- Use Instagram Graph API
- More complex setup (see Instagram API docs)

---

## Workflow 2: Article → Short Video

### Deskripsi
Generate video pendek dari artikel untuk TikTok, YouTube Shorts, dan Instagram Reels.

**⚠️ COMPLEXITY WARNING:** Ini adalah workflow paling kompleks dan membutuhkan multiple AI services.

### Required Services & Costs

| Service | Purpose | Cost (Est.) |
|---------|---------|-------------|
| OpenAI GPT-4 | Script generation | $50-100/month |
| ElevenLabs | Text-to-speech | $50/month |
| Stable Diffusion API | Image generation | $50-100/month |
| FFmpeg (free) | Video assembly | Free |
| Remotion (optional) | Advanced video | $0-200/month |

**Total:** ~$200-300/month for automation

### Workflow Structure

```
┌──────────────────────┐
│ 1. Webhook Trigger   │ ← Article published
└─────────┬────────────┘
          │
┌─────────▼────────────┐
│ 2. Extract Content   │
│   - Title            │
│   - Key points       │
│   - Images           │
└─────────┬────────────┘
          │
┌─────────▼────────────────┐
│ 3. GPT-4: Generate Script│ ← OpenAI API
│   - 30-60 second script  │
│   - 3-5 scenes           │
│   - Narration text       │
└─────────┬────────────────┘
          │
┌─────────▼─────────────────┐
│ 4. ElevenLabs: TTS        │ ← Generate voice
│   - Convert script to MP3 │
└─────────┬─────────────────┘
          │
┌─────────▼──────────────────┐
│ 5. Stable Diffusion:       │ ← Generate visuals
│   Generate scene images    │
│   - 3-5 images per video   │
└─────────┬──────────────────┘
          │
┌─────────▼─────────────────┐
│ 6. FFmpeg: Assemble Video │
│   - Combine images        │
│   - Add voiceover         │
│   - Add captions          │
│   - Export 9:16 (mobile)  │
└─────────┬─────────────────┘
          │
          ├─────────┬─────────┐
┌─────────▼───┐ ┌──▼──────┐ ┌▼────────┐
│ 7a. TikTok  │ │ 7b. YT  │ │ 7c. IG  │
│   Upload    │ │  Upload │ │  Upload │
└─────────────┘ └─────────┘ └─────────┘
```

### Detailed Node Configurations

#### Node 3: GPT-4 Script Generation

```javascript
// n8n HTTP Request to OpenAI
const article = $json;

const prompt = `Buatkan script video pendek 30-60 detik untuk TikTok/YouTube Shorts tentang artikel berikut:

Judul: ${article.title}
Konten: ${article.content.substring(0, 500)}

Format output sebagai JSON dengan struktur:
{
  "hook": "Kalimat menarik pembuka (5 detik)",
  "scenes": [
    {
      "narration": "Teks narasi scene 1",
      "visual_description": "Deskripsi visual yang akan di-generate",
      "duration": 8
    },
    // ... 2-4 scenes lagi
  ],
  "cta": "Call to action penutup"
}

Gunakan bahasa Indonesia yang engaging untuk audience Muslim.`;

return {
  json: {
    model: "gpt-4",
    messages: [
      {
        role: "system",
        content: "You are a video script writer specializing in short-form Islamic content."
      },
      {
        role: "user",
        content: prompt
      }
    ],
    temperature: 0.7,
    response_format: { type: "json_object" }
  }
};
```

#### Node 4: ElevenLabs TTS

```json
{
  "name": "Generate Voice",
  "type": "n8n-nodes-base.httpRequest",
  "parameters": {
    "url": "https://api.elevenlabs.io/v1/text-to-speech/VOICE_ID",
    "method": "POST",
    "authentication": "headerAuth",
    "headerParameters": {
      "parameters": [
        {
          "name": "xi-api-key",
          "value": "={{ $credentials.elevenLabsApiKey }}"
        }
      ]
    },
    "bodyParameters": {
      "parameters": [
        {
          "name": "text",
          "value": "={{ $json.fullNarration }}"
        },
        {
          "name": "voice_settings",
          "value": {
            "stability": 0.5,
            "similarity_boost": 0.75
          }
        }
      ]
    },
    "options": {
      "response": {
        "response": {
          "responseFormat": "file"
        }
      }
    }
  }
}
```

#### Node 5: Stable Diffusion Image Generation

```javascript
// For each scene, generate image
const scenes = $json.script.scenes;
const images = [];

for (const scene of scenes) {
  const imagePrompt = `Islamic themed illustration: ${scene.visual_description}.
    Style: Modern, clean, professional.
    Aspect ratio: 9:16 (vertical).
    High quality, suitable for social media.`;

  // Call Stable Diffusion API
  const response = await $http.post('https://api.stability.ai/v1/generation/stable-diffusion-xl-1024-v1-0/text-to-image', {
    text_prompts: [
      {
        text: imagePrompt,
        weight: 1
      }
    ],
    cfg_scale: 7,
    height: 1792,
    width: 1024,
    samples: 1,
    steps: 30
  }, {
    headers: {
      'Authorization': `Bearer ${$credentials.stabilityApiKey}`,
      'Content-Type': 'application/json'
    }
  });

  images.push({
    scene: scene,
    imageData: response.data.artifacts[0].base64
  });
}

return { json: { images } };
```

#### Node 6: FFmpeg Video Assembly

```bash
#!/bin/bash
# This runs in n8n Execute Command node or separate script

# Input files from previous nodes
IMAGES_DIR="/tmp/n8n/images"
AUDIO_FILE="/tmp/n8n/voiceover.mp3"
OUTPUT_FILE="/tmp/n8n/output_video.mp4"

# Create video from images with transitions
ffmpeg -y \
  -loop 1 -t 8 -i "${IMAGES_DIR}/scene1.jpg" \
  -loop 1 -t 10 -i "${IMAGES_DIR}/scene2.jpg" \
  -loop 1 -t 7 -i "${IMAGES_DIR}/scene3.jpg" \
  -loop 1 -t 10 -i "${IMAGES_DIR}/scene4.jpg" \
  -i "${AUDIO_FILE}" \
  -filter_complex "\
    [0:v]scale=1080:1920,setsar=1,fade=t=in:st=0:d=0.5,fade=t=out:st=7.5:d=0.5[v0]; \
    [1:v]scale=1080:1920,setsar=1,fade=t=in:st=0:d=0.5,fade=t=out:st=9.5:d=0.5[v1]; \
    [2:v]scale=1080:1920,setsar=1,fade=t=in:st=0:d=0.5,fade=t=out:st=6.5:d=0.5[v2]; \
    [3:v]scale=1080:1920,setsar=1,fade=t=in:st=0:d=0.5,fade=t=out:st=9.5:d=0.5[v3]; \
    [v0][v1][v2][v3]concat=n=4:v=1:a=0[outv]" \
  -map "[outv]" -map 4:a \
  -c:v libx264 -preset slow -crf 18 \
  -c:a aac -b:a 192k \
  -pix_fmt yuv420p \
  -movflags +faststart \
  "${OUTPUT_FILE}"

echo "Video created: ${OUTPUT_FILE}"
```

#### Node 7: Upload to Social Platforms

**TikTok:**
- No official API for uploading (yet)
- Workaround: Use TikTok Creator Portal API (limited access)
- Or: Manual upload via web interface

**YouTube Shorts:**
```json
{
  "name": "Upload to YouTube",
  "type": "n8n-nodes-base.youTube",
  "parameters": {
    "operation": "upload",
    "title": "={{ $json.title }}",
    "description": "={{ $json.description }}",
    "videoFile": "={{ $binary.video }}",
    "categoryId": "22",
    "options": {
      "shorts": true
    }
  }
}
```

**Instagram Reels:**
- Use Instagram Graph API
- Requires Facebook Business account

---

## Workflow 3: Event Reminders

### Simple reminder workflow

```
┌─────────────────┐
│ 1. Cron Trigger │ ← Daily at 9 AM
└────────┬────────┘
         │
┌────────▼─────────────────┐
│ 2. HTTP: Get Upcoming    │ ← WordPress API
│    Events (next 24h)     │
└────────┬─────────────────┘
         │
┌────────▼─────────────┐
│ 3. Loop Over Events  │
└────────┬─────────────┘
         │
┌────────▼──────────────┐
│ 4. Get Attendees List │
└────────┬──────────────┘
         │
┌────────▼────────────────┐
│ 5. Send Email Reminder  │ ← SMTP or SendGrid
└─────────────────────────┘
```

---

## Security & Best Practices

### 1. Secure API Keys

**Never** hardcode API keys. Use:
- Environment variables
- n8n credentials storage
- WordPress wp-config.php constants

### 2. Rate Limiting

Add delays between API calls:
```javascript
// In n8n Function node
await new Promise(resolve => setTimeout(resolve, 1000)); // Wait 1 second
```

### 3. Error Handling

```javascript
try {
  // API call
  const result = await $http.post(url, data);
  return { json: result };
} catch (error) {
  // Log error and continue
  console.error('API Error:', error.message);
  return {
    json: {
      error: true,
      message: error.message
    }
  };
}
```

### 4. Webhook Security

Always verify signatures:
```php
// WordPress
$signature = $_SERVER['HTTP_X_MAJELIS_SIGNATURE'];
$expected = hash_hmac('sha256', $body, MAJELIS_WEBHOOK_SECRET);
if (!hash_equals($expected, $signature)) {
    wp_die('Invalid signature', '', 401);
}
```

### 5. Queue Management

- Limit queue size to last 100 items
- Clean up completed items older than 30 days
- Monitor failed items and retry

---

## Testing Workflows

### Test Webhook

```bash
# Trigger n8n workflow manually
curl -X POST https://n8n.yourdomain.com/webhook/majelis \
  -H "Content-Type: application/json" \
  -d '{
    "action": "event_published",
    "event_id": 123,
    "title": "Test Event",
    "url": "https://majelis.info/events/test"
  }'
```

### Test WordPress Integration

```bash
# Trigger from WordPress
wp eval 'do_action("majelis_event_published", 123, array("title" => "Test"));'
```

---

## Monitoring & Logs

### n8n Execution Logs

- Check n8n dashboard → Executions
- View failed executions
- Debug with execution data

### WordPress Logs

```php
// Enable WP debug logging in wp-config.php
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

// View logs
tail -f /home/user/majelis.info/wp-content/debug.log
```

### Cron Job Logs

```bash
# View automation logs
tail -f /home/user/logs/automation.log

# View reminder logs
tail -f /home/user/logs/reminders.log
```

---

## Next Steps

1. ✅ Setup n8n instance (cloud or self-hosted)
2. ✅ Configure WordPress API endpoints
3. ✅ Create Workflow 1: Article → Social Media (start simple)
4. ⏸️ Create Workflow 2: Article → Video (advanced, optional)
5. ✅ Create Workflow 3: Event Reminders
6. ✅ Setup monitoring and alerts
7. ✅ Test all workflows
8. 🚀 Launch!

---

## Resources

- **n8n Documentation:** https://docs.n8n.io/
- **WordPress REST API:** https://developer.wordpress.org/rest-api/
- **OpenAI API:** https://platform.openai.com/docs/
- **ElevenLabs API:** https://docs.elevenlabs.io/
- **FFmpeg Guide:** https://ffmpeg.org/ffmpeg.html
- **Social Media APIs:**
  - Twitter: https://developer.twitter.com/en/docs
  - Facebook: https://developers.facebook.com/docs/
  - Instagram: https://developers.facebook.com/docs/instagram-api/

---

## Support

Jika ada pertanyaan atau butuh bantuan setup:
1. Check n8n community: https://community.n8n.io/
2. WordPress support forums
3. API provider documentation

Good luck dengan automation! 🚀
