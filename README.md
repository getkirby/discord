# Kirby Discord plugin

A simple wrapper to send Discord webhooks

## Installation

### Download

Download and copy this repository to `/site/plugins/discord`.

### Git submodule

```
git submodule add https://github.com/getkirby/discord.git site/plugins/discord
```

### Composer

```
composer require getkirby/discord
```

## How it works?

```php
use Kirby\Discord\Discord;

Discord::submit(
	webhook: 'https://discord.com/api/webhooks/xxx/xxx',
	username: 'kirbybot',
	avatar: 'https://example.com/avatar.jpg',
	title: '🔥 Message Title',
	color: '#ebc747',
	description: 'Here goes some nice text',
	author: [
		'name' => 'Ron Swanson',
		'url'  => 'https://example.com',
		'icon' => 'https://example.com/someicon.png'
	],
	fields: [
		[
			'name'  => 'This is a custom field',
			'value' => 'Add any value here'
		],
		[
			'name'  => 'This is another one',
			'value' => 'https://canbeanurl.com'
		],
	],
	footer: 'Some text for the footer'
);
```

## What’s Kirby?

- **[getkirby.com](https://getkirby.com)** – Get to know the CMS.
- **[Try it](https://getkirby.com/try)** – Take a test ride with our online demo. Or download one of our kits to get started.
- **[Documentation](https://getkirby.com/docs/guide)** – Read the official guide, reference and cookbook recipes.
- **[Issues](https://github.com/getkirby/kirby/issues)** – Report bugs and other problems.
- **[Feedback](https://feedback.getkirby.com)** – You have an idea for Kirby? Share it.
- **[Forum](https://forum.getkirby.com)** – Whenever you get stuck, don't hesitate to reach out for questions and support.
- **[Discord](https://chat.getkirby.com)** – Hang out and meet the community.
- **[Mastodon](https://mastodon.social/@getkirby)** – Follow us in the Fediverse.
- **[Bluesky](https://bsky.app/profile/getkirby.com)** – Follow us on Bluesky.
- **[Instagram](https://www.instagram.com/getkirby/)** – Share your creations: #madewithkirby.

---

## License

MIT

## Credits

- [Kirby Team](https://getkirby.com)
