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
(3, 'Gardes-champetres');

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
(3, 'Alpes d\'Huez', '2020-02-17', 2),
(4, 'Courchevel', '2021-02-12', 1),
(5, 'La Bresse', '2021-12-12', 0),
(6, 'Chamonix', '2022-01-25', 0);

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

INSERT INTO `participant` (`id`, `last_name`, `first_name`, `mail`, `birth_date`, `img_link`, `category_id`, `profile_id`) VALUES
(1, 'Macon', 'Franck', 'franck.macon@test.fr', '1970-01-12', 'unknown.jpg', 1, 1),
(2, 'Philippe', 'René', 'rene.phil@test.fr', '1960-10-12', '5f97ee79e158c.jpeg', 2, 1),
(3, 'Dupont', 'Philippe', 'phil.dupont@test.fr', '1960-10-12', '5f97ee79e158c.jpeg', 3, 1),
(4, 'Martin', 'Louis', 'louis.martin@exemple.com', '1970-01-13', '5f97ee79e158c.jpeg', 4, 1),
(5, 'Pierre', 'Jean', 'jean-pierre@exemple.com', '1970-01-13', '5f97e5690b7c4.jpeg', 5, 1),
(6, 'Pierre', 'Jeanne', 'jeanne@exemple.com', '1977-10-13', '5f97ee79e158c.jpeg', 6, 1),
(7, 'Roger', 'Jean', 'roger.j@exemple.com', '1987-06-13', 'unknown.jpg', 7, 1),
(8, 'Roger', 'Robert', 'rr@exemple.com', '1994-06-08', '5f97fb01430a2.jpeg', 1, 2),
(9, 'Dupont', 'Jean', 'dupont.jean@exemple.com', '1995-06-21', '5f97fb01430a1.jpeg', 2, 2),
(10, 'Bernard', 'Jean', 'bernard.j@exemple.com', '1987-06-13', 'unknown.jpg', 3, 2),
(11, 'Thomas', 'Franck', 'franck.thomas@test.fr', '1970-01-12', 'unknown.jpg', 4, 2),
(12, 'Dubois', 'René', 'rene.dubois@test.fr', '1960-10-12', '5f97ee79e158c.jpeg', 5, 2),
(13, 'Richard', 'Philippe', 'phil.richard@test.fr', '1960-10-12', '5f97ee79e158c.jpeg', 6, 2),
(14, 'Martin', 'Richard', 'richard.martin@exemple.com', '1970-01-13', '5f97ee79e158c.jpeg', 7, 2),
(15, 'Simon', 'Jean', 'jean-simon@exemple.com', '1970-01-13', '5f97e5690b7c4.jpeg', 1, 3),
(16, 'Pierre', 'Robin', 'robin.pierre@exemple.com', '1977-10-13', '5f97ee79e158c.jpeg', 2, 3),
(17, 'David', 'Jean', 'david.j@exemple.com', '1987-06-13', 'unknown.jpg', 3, 3),
(18, 'Legrand', 'Robert', 'rlegrand@exemple.com', '1994-06-08', '5f97fb01430a2.jpeg', 4, 3),
(19, 'Muller', 'Jean', 'muller.j@exemple.com', '1958-06-13', 'unknown.jpg', 5, 3),
(20, 'Legrand', 'Robin', 'rlegrand@exemple.com', '1964-06-08', '5f97fb01430a2.jpeg', 6, 3),
(21, 'Michel', 'Jean', 'michel.jean@exemple.com', '1995-06-21', '5f97fb01430a1.jpeg', 7, 3);
-- --------------------------------------------------------

--
-- Structure de la table `result`
--

CREATE TABLE IF NOT EXISTS `result` (
  `id` int(11) PRIMARY KEY NOT NULL  AUTO_INCREMENT,
  `race_id` int(11) NOT NULL,
  `participant_id` int(11) NOT NULL,
  `average_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
CONSTRAINT fk_race_id         -- On donne un nom à notre clé
        FOREIGN KEY (race_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES race(id),        -- Colonne de référence
CONSTRAINT fk_participant_id         -- On donne un nom à notre clé
        FOREIGN KEY (participant_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES participant(id)       -- Colonne de référence
) ENGINE=InnoDB;


INSERT INTO `result` (`id`, `race_id`, `participant_id`, `average_time`) VALUES
(1, 4, 1, NULL),
(2, 4, 2, NULL),
(3, 1, 2, '03:00.990000'),
(4, 1, 1, '02:41.170000'),
(5, 1, 3, '02:41.150000'),
(6, 1, 4, '03:37.980000'),
(7, 1, 5, '02:41.210000'),
(8, 1, 6, '03:37.960000'),
(9, 1, 7, '03:37.980000'),
(10, 1, 8, '03:00.440000'),
(11, 1, 9, '03:01.500000'),
(12, 1, 10, '05:00.670000'),
(13, 1, 11, '03:11.500000'),
(14, 1, 12, '03:37.940000'),
(15, 1, 13, '02:41.170000'),
(16, 1, 14, '03:00.440000'),
(17, 1, 15, '03:38.500000'),
(18, 1, 16, '03:00.610000'),
(19, 1, 17, '02:41.150000'),
(20, 1, 18, '03:37.960000'),
(21, 1, 19, '03:38.000000'),
(22, 1, 20, '03:00.610000'),
(23, 1, 21, '02:41.190000'),
(24, 3, 1, '02:41.170000'),
(25, 3, 3, '02:41.150000'),
(26, 3, 4, '03:37.980000'),
(27, 3, 5, '02:41.210000'),
(28, 3, 6, '03:37.960000'),
(29, 3, 7, '03:37.980000'),
(30, 3, 8, '03:00.440000'),
(31, 3, 9, '03:01.500000'),
(32, 3, 10, '05:00.670000'),
(33, 3, 11, '03:11.500000'),
(34, 3, 12, '03:37.940000'),
(35, 3, 13, '02:41.170000'),
(36, 3, 14, '03:00.440000'),
(37, 3, 15, '03:38.500000'),
(38, 3, 16, '03:00.610000'),
(39, 3, 17, '02:41.150000'),
(40, 3, 18, '03:37.960000'),
(41, 3, 19, '03:38.000000'),
(42, 3, 20, '03:00.610000'),
(43, 3, 21, '02:41.190000'),
(44, 1, 3, '03:00.990000');
-- --------------------------------------------------------

--
-- Structure de la table `stage`
--

CREATE TABLE IF NOT EXISTS `stage` (
  `id` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `result_id` int(11) NOT NULL,
  `stage_nb` int(11) NOT NULL,
 -- `time` time DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
CONSTRAINT fk_result_id         -- On donne un nom à notre clé
        FOREIGN KEY (result_id)             -- Colonne sur laquelle on crée la clé
        REFERENCES result(id)        -- Colonne de référence
) ENGINE=InnoDB;



INSERT INTO `stage` (`id`, `result_id`, `stage_nb`, `time`) VALUES
(1, 12, 1, '03:30.200000'),
(2, 12, 2, '01:30.470000'),
(3, 19, 1, '01:00.570000'),
(4, 19, 2, '01:40.580000'),
(5, 14, 1, '01:30.470000'),
(6, 14, 2, '02:07.470000'),
(7, 11, 1, '01:30.580000'),
(8, 11, 2, '01:30.470000'),
(9, 5, 1, '01:00.570000'),
(10, 5, 2, '01:40.580000'),
(11, 20, 1, '01:30.480000'),
(12, 20, 2, '02:07.480000'),
(13, 22, 1, '01:30.360000'),
(14, 22, 2, '01:30.250000'),
(15, 4, 1, '01:00.580000'),
(16, 4, 2, '01:40.590000'),
(17, 6, 1, '01:30.490000'),
(18, 6, 2, '02:07.490000'),
(19, 16, 1, '01:30.140000'),
(20, 16, 2, '01:30.300000'),
(21, 23, 1, '01:00.590000'),
(22, 23, 2, '01:40.600000'),
(23, 21, 1, '01:30.500000'),
(24, 21, 2, '02:07.500000'),
(25, 3, 1, '01:30.800000'),
(26, 3, 2, '01:30.190000'),
(27, 7, 1, '01:00.600000'),
(28, 7, 2, '01:40.610000'),
(29, 8, 1, '01:30.480000'),
(30, 8, 2, '02:07.480000'),
(31, 18, 1, '01:30.360000'),
(32, 18, 2, '01:30.250000'),
(33, 15, 1, '01:00.580000'),
(34, 15, 2, '01:40.590000'),
(35, 9, 1, '01:30.490000'),
(36, 9, 2, '02:07.490000'),
(37, 10, 1, '01:30.140000'),
(38, 10, 2, '01:30.300000'),
(39, 17, 1, '02:07.470000'),
(40, 17, 2, '01:30.580000'),
(41, 13, 1, '01:30.470000'),
(42, 13, 2, '01:40.580000'),
(43, 19, 1, '01:00.570000'),
(44, 19, 2, '01:40.580000'),
(45, 14, 1, '01:30.470000'),
(46, 14, 2, '02:07.470000'),
(47, 11, 1, '01:30.580000'),
(48, 11, 2, '01:30.470000'),
(49, 5, 1, '01:00.570000'),
(50, 5, 2, '01:40.580000'),
(51, 20, 1, '01:30.480000'),
(52, 20, 2, '02:07.480000'),
(53, 22, 1, '01:30.360000'),
(54, 22, 2, '01:30.250000'),
(55, 4, 1, '01:00.580000'),
(56, 4, 2, '01:40.590000'),
(57, 6, 1, '01:30.490000'),
(58, 6, 2, '02:07.490000'),
(59, 16, 1, '01:30.140000'),
(60, 16, 2, '01:30.300000'),
(61, 23, 1, '01:00.590000'),
(62, 23, 2, '01:40.600000'),
(63, 21, 1, '01:30.500000'),
(64, 21, 2, '02:07.500000'),
(65, 3, 1, '01:30.800000'),
(66, 3, 2, '01:30.190000'),
(67, 7, 1, '01:00.600000'),
(68, 7, 2, '01:40.610000'),
(69, 8, 1, '01:30.480000'),
(70, 8, 2, '02:07.480000'),
(71, 18, 1, '01:30.360000'),
(72, 18, 2, '01:30.250000'),
(73, 15, 1, '01:00.580000'),
(74, 15, 2, '01:40.590000'),
(75, 9, 1, '01:30.490000'),
(76, 9, 2, '02:07.490000'),
(77, 10, 1, '01:30.140000'),
(78, 10, 2, '01:30.300000'),
(79, 17, 1, '02:07.470000'),
(80, 17, 2, '01:30.580000'),
(81, 13, 1, '01:30.470000'),
(82, 13, 2, '01:40.580000'),
(83, 12, 1, '03:30.200000'),
(84, 12, 2, '01:30.470000');

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
