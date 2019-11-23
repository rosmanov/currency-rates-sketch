-- Note, Yes I know one should use a migration tool instead of raw SQL files in VCS.
-- The file is simply a demo.

--
-- Schema
--

CREATE TABLE currency (
    id int unsigned AUTO_INCREMENT,
    `code` varchar(5) NOT NULL DEFAULT '' COLLATE latin1_bin COMMENT 'International currency code such as USD, RUB, SEK etc.',
    `symbol` varchar(5) NOT NULL DEFAULT '' COLLATE utf8mb4_bin COMMENT 'Currency symbol in UTF-8',
    PRIMARY KEY (id),
    UNIQUE KEY u (`code`)
) engine=InnoDB DEFAULT CHARSET=utf8 COMMENT 'Currency entities';

CREATE TABLE currency_rate (
    scope_id INT unsigned NOT NULL DEFAULT 0 COMMENT 'Numeric constant value for distinguishing the different currency rate providers',
    from_currency_id INT unsigned NOT NULL DEFAULT 0 COMMENT 'ID of the currency converted to to_currency_id',
    to_currency_id INT unsigned NOT NULL DEFAULT 0 COMMENT 'ID of the currency to which the from_currency_id is converted',
    rate DECIMAL(16, 8) NOT NULL DEFAULT 0.0 COMMENT 'Currency rate in RUB',
    PRIMARY KEY (from_currency_id, to_currency_id, scope_id),
    FOREIGN KEY (from_currency_id) REFERENCES currency (id) ON DELETE CASCADE,
    FOREIGN KEY (to_currency_id) REFERENCES currency (id) ON DELETE CASCADE
) engine=InnoDB DEFAULT CHARSET=utf8 COMMENT 'Currency rates downloaded from different (REST) sources';

--
-- Test data
--

SET @RUB_ID := 1;
SET @USD_ID := 2;
SET @AUD_ID := 3;
SET @SEK_ID := 4;

INSERT INTO currency (id, `code`, `symbol`) VALUES
(@RUB_ID, 'RUB', '₽'),
(@USD_ID, 'USD', '$'),
(@AUD_ID, 'AUD', '$'),
(@SEK_ID, 'SEK', 'kr');

-- Central Bank Source
SET @CBR_SOURCE_ID := 1;
-- RBK Source
SET @RBK_SOURCE_ID := 2;

INSERT INTO currency_rate (scope_id, from_currency_id, to_currency_id, rate) VALUES
(@CBR_SOURCE_ID, @RUB_ID, @RUB_ID, 1),
(@CBR_SOURCE_ID, @USD_ID, @RUB_ID, 63.8430),
(@CBR_SOURCE_ID, @AUD_ID, @RUB_ID, 43.4132),
(@CBR_SOURCE_ID, @SEK_ID, @RUB_ID, 66.2286),

(@RBK_SOURCE_ID, @RUB_ID, @RUB_ID, 1),
(@RBK_SOURCE_ID, @USD_ID, @RUB_ID, 63.8200),
(@RBK_SOURCE_ID, @AUD_ID, @RUB_ID, 43.4032),
(@RBK_SOURCE_ID, @SEK_ID, @RUB_ID, 66.2086);
