# Flaming Diva - Project Context for Claude Code

## What This Is
E-commerce site for Diva, a fashion artist selling one-of-a-kind handcrafted pieces and custom embroidery patches. Immersive "virtual house tour" concept with WebGL shaders, themed rooms, and VIP membership.

Full brief: `/mnt/devdrive/projects/flamingdiva.com/flaming-diva-implementation-brief.md`

## Local Dev Environment
- **WordPress:** http://localhost:8090/wp-admin
- **phpMyAdmin:** http://localhost:8091 (root / fdrootpass)
- **Start Docker:** `docker compose up -d` (from this folder)
- **DB:** MySQL 8, db=flamingdiva, user=fduser, pass=fdpass, prefix=fd_
- **WP files:** `./wordpress/`
- Use `docker compose` (v2), NOT `docker-compose` (v1 has bug with Docker Engine 28)

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

## Status (as of March 2026)
- WordPress + WooCommerce installed and running locally
- Oxygen Builder 6 installed
- Logo redesign pending
- Client developing product photography assets
- WooCommerce setup wizard not yet run
- Oxygen theme build not yet started
- No hosting arranged (local dev only)
- Old abandoned site preserved at `/mnt/devdrive/projects/flamingdiva.com/flamingdiva-old/`
