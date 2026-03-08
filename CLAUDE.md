# Flaming Diva - Project Context for Claude Code

## What This Is
E-commerce site for Diva, a fashion artist selling one-of-a-kind handcrafted pieces and custom embroidery patches. Immersive "virtual house tour" concept with WebGL shaders, themed rooms, and VIP membership.

Full brief: `/mnt/devdrive/projects/flamingdiva.com/flaming-diva-implementation-brief.md`

## Local Dev Environment
- **Landing page:** http://localhost:8090/
- **WordPress / WooCommerce:** http://localhost:8090/shop/
- **WP Admin:** http://localhost:8090/shop/wp-admin/
- **phpMyAdmin:** http://localhost:8091 (root / fdrootpass)
- **Start Docker:** `docker compose up -d` (from this folder)
- **DB:** MySQL 8, db=flamingdiva, user=fduser, pass=fdpass, prefix=fd_
- **WP files:** `./shop/` (was `./wordpress/`, renamed)
- Use `docker compose` (v2), NOT `docker-compose` (v1 has bug with Docker Engine 28)

## Server Architecture (Docker Compose)
- **nginx** (port 8090) — reverse proxy / static file server
  - `/` → serves `./landingpage/` static files
  - `/shared/` → serves `./shared/` static files (bg-shader.js etc.)
  - `/arcade/` → serves `./arcade/` static files
  - `/shop/` → proxies to WordPress container (internal port 80)
  - Bare WP paths (`/wp-admin/`, `/wp-login.php`, etc.) → 301 redirect to `/shop/` equivalent
- **wordpress** container — no external port, internal only
- **mysql** container — internal only
- **phpmyadmin** (port 8091) — DB admin UI
- Config: `./config/nginx/default.conf`
- **IMPORTANT:** After editing `default.conf`, nginx needs a FULL container restart to pick up changes (bind mount has inode caching issue with `nginx -s reload`):
  `docker compose restart nginx`

## WordPress Config Notes
- WP_HOME and WP_SITEURL set to `http://localhost:8090/shop` via WORDPRESS_CONFIG_EXTRA in docker-compose.yml
- wp-cli installed in WP container: `docker exec flamingdiva_wp wp <command> --allow-root`
- To update DB URLs directly: `docker exec flamingdiva_db mysql -uroot -pfdrootpass flamingdiva -e "..."`

## Installed Plugins
- Oxygen Builder 6 + Breakdance Elements for Oxygen
- Breakdance WooCommerce for Oxygen
- WooCommerce + WooCommerce Stripe Gateway
- Widgets for Social Photo Feed (Instagram — needs connecting)

## Tech Stack
- WordPress + WooCommerce + Oxygen Builder 6
- WebGL shaders (5 types: Plasma, Lava, Aurora, Acid, Void)
- Rive character animations (Divarita hostess, golf cart)
- Airtable CRM (base ID: appvxKr7BLM75NquL) — NOT synced to WP, used for ops only
- Stripe payments, SiteGround hosting (not yet set up), GoDaddy DNS

## Site Concept — 9 Rooms
Each room = product category + WebGL shader background:
1. Entrance (Aurora)
2. Main Floor/Lounge (Plasma)
3. Pinball Arcade (Acid) — playable HTML5 games in `./arcade/`
4. Ping Pong Palace/UV Room (Acid/Void)
5. Back Deck & Backyard (Lava)
6. Diva's Room (Lava)
7. Diva's Closet — full catalog (Void)
8. Golf Cart — random room navigation
9. VIP Room — members only (Void/Aurora)

## Key Interactive Features
- Cover Flow 3D product carousel per room
- Divarita Hostess — animated cocktail server appears when cart has items
- Playa Party Cart — fur seats, pom-pom fringe, random room navigation
- Arcade games (6 prototype games in `./arcade/games/` — to be reskinned)
- Diva Points gamification — earn via games, redeem for discounts
- VIP slot machine in VIP room

## Brand
- Colors: Flame Orange #FF3800, Hot Pink #FF006B, Electric Purple #9400FF, Cosmic Cyan #00D4FF, Deep Space #06000E
- Logo: needs redesign (flagged as problem by client)
- Assets: `/mnt/devdrive/projects/flamingdiva.com/flaming diva 2025/`
- Logos: `./flaming diva 2025/newest logos/`
- Inventory photos: `./flaming diva 2025/Inventory Pix/`

## Airtable Tables
Products, Customers, Orders, Designs, Wholesale
Products table has AI Summary field (auto-generates copy from photos via Claude Sonnet)

## Product Pipeline
Diva photographs on ghost mannequin → standardize via OutfitChanger.com → upload to Airtable (AI writes copy) → manually enter in WooCommerce. Catalog under 50 items.

## VIP Membership
Auto-enrolled on first purchase. Physical welcome package: lanyard, Divarita poker chips, gift bag, welcome card. Lifestyle perks: party invites, concerts, bus trips, custom commission priority.

## Landing Page (`./landingpage/`)
- Fully built static landing page with WebGL shader background (`./shared/bg-shader.js`)
- Responsive via `transform: scale()` JS approach (no CSS breakpoints) — scales 1440×900 design to any viewport
- Shader label hover triggers screensaver dissolve (5s fade to black), click anywhere to restore (15s fade in)
- Idle 2 min → auto-screensaver
- 6 shader presets: Plasma (default), Lava, Aurora, Acid, Trip, Pane — persisted in localStorage
- Shared with arcade page: `./shared/bg-shader.js`
- GitHub Pages: https://lownotesb.github.io/flamingdiva.com/ (redirects to /landingpage/)

## Status (as of March 2026)
- Landing page: complete and live on GitHub Pages
- nginx reverse proxy: set up and working
- WordPress + WooCommerce: installed and running locally at /shop/
- Oxygen Builder 6 installed, theme build not yet started
- WooCommerce setup: pages exist (Cart, Checkout, My Account, Shop), wizard not fully run
- Logo redesign pending
- Client developing product photography assets
- No hosting arranged (local dev only)
- Old abandoned site preserved at `/mnt/devdrive/projects/flamingdiva.com/flamingdiva-old/`
