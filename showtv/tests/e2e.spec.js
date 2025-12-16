import { test, expect } from '@playwright/test';

test.describe('ShowTV E2E Tests', () => {
  test('should load homepage and display latest episodes', async ({ page }) => {
    await page.goto('/');

    // Check if page loaded
    await expect(page).toHaveTitle(/SHOW.TV/);

    // Check if latest episodes are displayed
    const episodeCards = page.locator('.show-card');
    const count = await episodeCards.count();
    expect(count).toBeGreaterThan(0);

    console.log(`Found ${count} latest episode cards on homepage`);
  });

  test('should navigate to shows page and display all shows', async ({ page }) => {
    await page.goto('/');

    // Click on "Browse all shows" button
    const browseButton = page.locator('text=/جميع المسلسلات/');
    await browseButton.click();

    // Wait for shows page to load
    await page.waitForURL(/\/shows/);

    // Check if shows are displayed
    const showCards = page.locator('.show-card');
    const count = await showCards.count();
    expect(count).toBeGreaterThan(0);
    expect(count).toBeGreaterThanOrEqual(30);

    console.log(`Found ${count} shows on shows page`);
  });

  test('should navigate to show detail page and display episodes', async ({ page }) => {
    await page.goto('/shows');

    // Click on first show
    const firstShow = page.locator('.show-card').first();
    await firstShow.click();

    // Wait for show detail page to load
    await page.waitForURL(/\/shows\/\d+/);

    // Check if episodes are displayed (each episode is a card)
    const episodeCards = page.locator('.card');
    const count = await episodeCards.count();
    expect(count).toBeGreaterThan(0);

    console.log(`Found ${count} episode cards on show detail page`);
  });

  test('should play episode video and display details', async ({ page }) => {
    await page.goto('/shows');

    // Click on first show
    const firstShow = page.locator('.show-card').first();
    await firstShow.click();

    // Wait for show detail page
    await page.waitForURL(/\/shows\/\d+/);

    // Click on first episode watch button
    const watchButton = page.locator('a[href*="episodes"]').first();
    await watchButton.click();

    // Wait for episode page to load
    await page.waitForURL(/\/episodes\/\d+/);

    // Check if video player is present
    const videoPlayer = page.locator('iframe[src*="youtube"], video');
    await expect(videoPlayer).toBeVisible();

    // Check episode details
    const episodeTitle = page.locator('.episode-title, h1');
    await expect(episodeTitle).toBeVisible();

    const episodeDescription = page.locator('.episode-description, p');
    await expect(episodeDescription).toBeVisible();

    // Check duration
    const duration = page.locator('text=/دقيقة/');
    await expect(duration).toBeVisible();

    console.log('Episode page loaded successfully with video player and details');
  });

  test('should display episode thumbnails in more episodes section', async ({ page }) => {
    await page.goto('/shows');

    // Click on first show
    const firstShow = page.locator('.show-card').first();
    await firstShow.click();

    // Click on first episode
    const watchButton = page.locator('a[href*="episodes"]').first();
    await watchButton.click();

    // Wait for episode page
    await page.waitForURL(/\/episodes\/\d+/);

    // Check if "More Episodes" section exists
    const moreEpisodesSection = page.locator('.more-episodes');
    await expect(moreEpisodesSection).toBeVisible();

    // Check if thumbnails are displayed (episode cards with background images)
    const thumbnails = page.locator('.episode-thumbnail');
    const count = await thumbnails.count();
    expect(count).toBeGreaterThan(0);

    console.log(`Found ${count} episode thumbnails in more episodes section`);
  });
});
