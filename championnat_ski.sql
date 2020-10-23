--
-- Base de données :  `championnat_ski`
--
DROP TABLE IF EXISTS `stage`;
DROP TABLE IF EXISTS `result`;
DROP TABLE IF EXISTS `participant`;

DROP TABLE IF EXISTS `race`;
DROP TABLE IF EXISTS `profile`;
DROP TABLE IF EXISTS `category`;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'M1'),
(2, 'M2'),
(3, 'M3'),
(4, 'Sénior'),
(5, 'V'),
(6, 'Snow'),
(7, 'Nouvelle Glisse (NG)');

-- --------------------------------------------------------

--
-- Structure de la table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB;

--
-- Déchargement des données de la table `profile`
--

INSERT INTO `profile` (`id`, `name`) VALUES
(1, 'ASVP'),
(2, 'Open'),
(3, 'Gardes-champêtres');

-- --------------------------------------------------------

--
-- Structure de la table `race`
--

CREATE TABLE IF NOT EXISTS `race` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB;

INSERT INTO `race` (`id`, `location`, `date`, `status`) VALUES
(1, 'Chamonix', '2019-01-12', 2),
(2, 'Isola 2000', '2020-01-12', 3),
(3, "Alpes d'Huez", '2020-02-17', 2),
(4, 'Courchevel', '2020-12-12', 1),
(5, 'La Bresse', '2021-01-25', 0),
(6, 'Chamonix', '2020-12-12', 0);

-- --------------------------------------------------------

--
-- Structure de la table `participant`
--

CREATE TABLE IF NOT EXISTS `participant` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date NOT NULL,
  `img_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  CONSTRAINT fk_category_id          -- On donne un nom à notre clé
        FOREIGN KEY (category_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES Category(id),        -- Colonne de référence
  CONSTRAINT fk_profile_id          -- On donne un nom à notre clé
        FOREIGN KEY (profile_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES profile(id)        -- Colonne de référence
) ENGINE=InnoDB;

-- --------------------------------------------------------

--
-- Structure de la table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) PRIMARY KEY NOT NULL,
  `race_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `average_time` time NOT NULL,
CONSTRAINT fk_race_id         -- On donne un nom à notre clé
        FOREIGN KEY (race_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES race(id),        -- Colonne de référence
CONSTRAINT fk_participant_id         -- On donne un nom à notre clé
        FOREIGN KEY (participant_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES participant(id)       -- Colonne de référence
) ENGINE=InnoDB;



-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE IF NOT EXISTS `stage` (
  `id` int(11) PRIMARY KEY NOT NULL,
  `result_id` int(11) NOT NULL,
  `stage_nb` int(11) NOT NULL,
  `time` time DEFAULT NULL,
CONSTRAINT fk_result_id         -- On donne un nom à notre clé
        FOREIGN KEY (result_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES result(id)        -- Colonne de référence
) ENGINE=InnoDB;



-- --------------------------------------------------------

--
-- Structure de la table `result`
--
/*
CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `race_participant_id` int(11) NOT NULL,
  `average_time` time NOT NULL,
CONSTRAINT fk_race_participant_id         -- On donne un nom à notre clé
        FOREIGN KEY (race_participant_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES race_participant(id)        -- Colonne de référence
) ENGINE=InnoDB;
*/
