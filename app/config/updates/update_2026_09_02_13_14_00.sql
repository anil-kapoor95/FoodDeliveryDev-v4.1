UPDATE `options`
SET
	`value` = CONCAT('theme1|theme2|theme3|theme4|theme5|theme6|theme7|theme8|theme9|theme10|theme11::', SUBSTRING_INDEX(`value`, '::', -1)),
	`label` = 'Theme 1|Theme 2|Theme 3|Theme 4|Theme 5|Theme 6|Theme 7|Theme 8|Theme 9|Theme 10|Theme 11'
WHERE `key` = 'o_theme'
	AND `value` NOT LIKE '%theme11%';

INSERT IGNORE INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES (NULL, 'option_themes_ARRAY_11', 'backend', 'option_themes_ARRAY_11', 'script', NULL);

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'option_themes_ARRAY_11' LIMIT 1);

INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 11', 'script');

INSERT IGNORE INTO `options`
	(`foreign_id`, `key`, `tab_id`, `value`, `label`, `type`, `order`, `is_visible`, `style`)
VALUES
	(1, 'o_theme11_color_header_bg',    99, '#14161c', 'Theme 11 / Header background',                          'string', NULL, 0, NULL),
	(1, 'o_theme11_color_header_text',  99, '#ffffff', 'Theme 11 / Header text',                                 'string', NULL, 0, NULL),
	(1, 'o_theme11_color_primary',      99, '#ff4d3d', 'Theme 11 / Primary / accent colour',                     'string', NULL, 0, NULL),
	(1, 'o_theme11_color_primary_text', 99, '#ffffff', 'Theme 11 / Primary button text',                         'string', NULL, 0, NULL),
	(1, 'o_theme11_color_success',      99, '#22c55e', 'Theme 11 / Success colour (completed step, available)',  'string', NULL, 0, NULL),
	(1, 'o_theme11_color_link',         99, '#2f6fed', 'Theme 11 / Link colour',                                 'string', NULL, 0, NULL),
	(1, 'o_theme11_color_body_bg',      99, '#f7f5f2', 'Theme 11 / Page background',                             'string', NULL, 0, NULL),
	(1, 'o_theme11_color_card_bg',      99, '#ffffff', 'Theme 11 / Card background',                             'string', NULL, 0, NULL),
	(1, 'o_theme11_color_text',         99, '#1a1a1a', 'Theme 11 / Main text colour',                            'string', NULL, 0, NULL),
	(1, 'o_theme11_color_muted',        99, '#79808a', 'Theme 11 / Secondary text colour',                       'string', NULL, 0, NULL),
	(1, 'o_theme11_color_border',       99, '#ececec', 'Theme 11 / Border colour',                               'string', NULL, 0, NULL);

INSERT IGNORE INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`)
VALUES
	(NULL, 'infoTheme11ColorsTitle',     'backend', 'Label / Theme 11 colours - panel title',              'script', NULL),
	(NULL, 'infoTheme11ColorsDesc',      'backend', 'Label / Theme 11 colours - panel description',        'script', NULL),
	(NULL, 'lblTheme11ColorsSaved',      'backend', 'Label / Theme 11 colours - saved banner',              'script', NULL),
	(NULL, 'lblTheme11ColorGroupHeader', 'backend', 'Label / Theme 11 colours - group: header',             'script', NULL),
	(NULL, 'lblTheme11ColorHeaderBg',    'backend', 'Label / Theme 11 colour - Header background',          'script', NULL),
	(NULL, 'lblTheme11ColorHeaderText',  'backend', 'Label / Theme 11 colour - Header text',                'script', NULL),
	(NULL, 'lblTheme11ColorGroupButtons','backend', 'Label / Theme 11 colours - group: buttons & accent',   'script', NULL),
	(NULL, 'lblTheme11ColorPrimary',     'backend', 'Label / Theme 11 colour - Primary / accent',           'script', NULL),
	(NULL, 'lblTheme11ColorPrimaryText', 'backend', 'Label / Theme 11 colour - Primary button text',        'script', NULL),
	(NULL, 'lblTheme11ColorSuccess',     'backend', 'Label / Theme 11 colour - Success',                    'script', NULL),
	(NULL, 'lblTheme11ColorLink',        'backend', 'Label / Theme 11 colour - Link',                       'script', NULL),
	(NULL, 'lblTheme11ColorGroupPage',   'backend', 'Label / Theme 11 colours - group: page & text',        'script', NULL),
	(NULL, 'lblTheme11ColorBodyBg',      'backend', 'Label / Theme 11 colour - Page background',            'script', NULL),
	(NULL, 'lblTheme11ColorCardBg',      'backend', 'Label / Theme 11 colour - Card background',            'script', NULL),
	(NULL, 'lblTheme11ColorText',        'backend', 'Label / Theme 11 colour - Main text',                  'script', NULL),
	(NULL, 'lblTheme11ColorMuted',       'backend', 'Label / Theme 11 colour - Secondary text',             'script', NULL),
	(NULL, 'lblTheme11ColorBorder',      'backend', 'Label / Theme 11 colour - Border',                     'script', NULL),
	(NULL, 'btnTheme11ColorsSave',       'backend', 'Label / Theme 11 colours - Save button',                'script', NULL);

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'infoTheme11ColorsTitle' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Theme 11 colours', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'infoTheme11ColorsDesc' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Theme 11 is the only theme with color customization. Pick colours for each part of the customer-facing site below, then save - leave a field on its default to keep the built-in colour.', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorsSaved' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Theme 11 colours have been saved.', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorGroupHeader' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Header', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorHeaderBg' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Header background', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorHeaderText' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Header text', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorGroupButtons' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Buttons & accent', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorPrimary' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Primary / accent colour', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorPrimaryText' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Primary button text', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorSuccess' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Success colour (completed step, available)', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorLink' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Link colour', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorGroupPage' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Page & text', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorBodyBg' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Page background', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorCardBg' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Card background', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorText' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Main text colour', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorMuted' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Secondary text colour', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'lblTheme11ColorBorder' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Border colour', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'btnTheme11ColorsSave' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Save colours', 'script');

-- Success banner shown on the Integration Code page after saving the Theme 11 colours
-- (next_action=pjActionInstall redirects with &err=AO08; AO01-AO07 are already used by
-- the script's other option-save forms).
INSERT IGNORE INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`)
VALUES
	(NULL, 'error_titles_ARRAY_AO08', 'backend', 'error_titles_ARRAY_AO08', 'script', NULL),
	(NULL, 'error_bodies_ARRAY_AO08', 'backend', 'error_bodies_ARRAY_AO08', 'script', NULL);

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'error_titles_ARRAY_AO08' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Colours updated', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'error_bodies_ARRAY_AO08' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjBaseField', '::LOCALE::', 'title', 'Theme 11 colours have been saved.', 'script');

INSERT IGNORE INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`)
VALUES
	(NULL, 'front_item', 'backend', 'front_item', 'script', NULL),
	(NULL, 'front_items', 'backend', 'front_items', 'script', NULL),
	(NULL, 'front_view_all', 'backend', 'front_view_all', 'script', NULL),
	(NULL, 'front_best_seller', 'backend', 'front_best_seller', 'script', NULL),
	(NULL, 'front_favorite', 'backend', 'front_favorite', 'script', NULL),
	(NULL, 'front_from_price', 'backend', 'front_from_price', 'script', NULL);

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'front_item' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'item', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'front_items' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'items', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'front_view_all' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'View all', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'front_best_seller' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Best Seller', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'front_favorite' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'Add to favourites', 'script');

SET @id := (SELECT `id` FROM `fields` WHERE `key` = 'front_from_price' LIMIT 1);
INSERT IGNORE INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES (NULL, @id, 'pjField', '::LOCALE::', 'title', 'From', 'script');

