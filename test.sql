-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mer 31 Mai 2017 à 00:41
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `test`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

CREATE TABLE `admins` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'adminroot', '$2y$10$JlZxSa7sK7dNLtFRHHKsDesi/z9/7f7KLlC9N5w4k4QEwpSDqJ2gO', 'pW6FF9DEF2Z15i8wrU9aMX0bsjSArMkrqRRgtXyQ6DaFTuxVJphF0SRpE10D', NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `annee_universitaire`
--

CREATE TABLE `annee_universitaire` (
  `annee` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `annee_universitaire`
--

INSERT INTO `annee_universitaire` (`annee`) VALUES
('L1'),
('L2'),
('L3'),
('M1');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commission_de_validation`
--

CREATE TABLE `commission_de_validation` (
  `id` int(10) UNSIGNED NOT NULL,
  `Nom` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Domaine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `commission_de_validation`
--

INSERT INTO `commission_de_validation` (`id`, `Nom`, `Domaine`, `created_at`, `updated_at`) VALUES
(1, 'Commission web licence', 'Développement Web et Mobile', '2017-05-30 10:31:20', '2017-05-30 10:31:20');

-- --------------------------------------------------------

--
-- Structure de la table `company`
--

CREATE TABLE `company` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Raison_sociale` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `registre_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `company`
--

INSERT INTO `company` (`id`, `created_at`, `updated_at`, `Raison_sociale`, `registre_image`) VALUES
(1, '2017-05-29 20:57:43', '2017-05-29 20:57:43', 'Air Algérie', 'storage/Users/Company/RegistreDeCommerce/aIZi7MoGERbZlnNhJKEs.jpg'),
(3, '2017-05-30 14:54:07', '2017-05-30 14:54:07', 'Elite company', 'storage/Users/Company/RegistreDeCommerce/JE3iCAFlfoeqb12e3MjD.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `cursus`
--

CREATE TABLE `cursus` (
  `student_id` int(11) NOT NULL,
  `annee_universitaire_id` varchar(5) NOT NULL,
  `Moyenne` float NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `cursus`
--

INSERT INTO `cursus` (`student_id`, `annee_universitaire_id`, `Moyenne`) VALUES
(1, 'L1', 14.93),
(1, 'L2', 14.56);

-- --------------------------------------------------------

--
-- Structure de la table `deadline`
--

CREATE TABLE `deadline` (
  `id` int(11) NOT NULL,
  `Phase` varchar(100) NOT NULL,
  `Date_debut` date NOT NULL,
  `Date_fin` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `deadline`
--

INSERT INTO `deadline` (`id`, `Phase`, `Date_debut`, `Date_fin`) VALUES
(1, 'Soumission', '2017-05-02', '2017-05-18'),
(5, 'Validation', '2017-04-23', '2017-04-29'),
(6, 'Candidature', '2017-05-13', '2017-06-18');

-- --------------------------------------------------------

--
-- Structure de la table `demande_binome`
--

CREATE TABLE `demande_binome` (
  `Student1_id` int(11) NOT NULL,
  `Student2_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `demande_binome`
--

INSERT INTO `demande_binome` (`Student1_id`, `Student2_id`) VALUES
(1, 3),
(4, 1);

-- --------------------------------------------------------

--
-- Structure de la table `keyword`
--

CREATE TABLE `keyword` (
  `keyword` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `keyword`
--

INSERT INTO `keyword` (`keyword`) VALUES
(''),
('AI'),
('Analyse'),
('Android'),
('ANTLR'),
('APP'),
('Application'),
('ARTIFICIAL'),
('au'),
('Big'),
('boursières'),
('communautés'),
('d\'une'),
('dans'),
('data'),
('de'),
('des'),
('Détection'),
('Dev'),
('domaine'),
('Domotico'),
('Domotique'),
('données'),
('dynamique'),
('e_environnement'),
('e-commerce'),
('envioronnement'),
('événementiel:'),
('Exploration'),
('Gamedev'),
('Gaming'),
('gestion'),
('IA'),
('INPT'),
('IOS'),
('l\'évolution'),
('le'),
('les'),
('mini-jeux'),
('Mining'),
('Mobile'),
('MRU'),
('Partner'),
('Personne'),
('PFE'),
('PFE_INPT'),
('Plateforme'),
('Réalisation'),
('rentabilité'),
('réseaux'),
('Simulateur'),
('sociaux'),
('Softwalrus'),
('SQL'),
('temps'),
('transactions'),
('Up!'),
('Users'),
('Utilisateurs'),
('virtuel'),
('voyage'),
('WEB');

-- --------------------------------------------------------

--
-- Structure de la table `keyword_post`
--

CREATE TABLE `keyword_post` (
  `keyword_id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `keyword_post`
--

INSERT INTO `keyword_post` (`keyword_id`, `post_id`) VALUES
('', 20),
('', 25),
('Analyse', 16),
('Android', 1),
('android', 25),
('ANTLR', 9),
('Application', 3),
('application', 17),
('application', 18),
('Big', 14),
('Big', 15),
('communautés', 7),
('d\'une', 17),
('d\'une', 18),
('dans', 7),
('dans', 17),
('dans', 18),
('data', 14),
('data', 15),
('Data', 16),
('de', 3),
('de', 5),
('de', 6),
('de', 15),
('des', 7),
('des', 16),
('Détection', 7),
('Dev', 1),
('Dev', 2),
('Dev', 5),
('domaine', 17),
('domaine', 18),
('Domotico', 1),
('Domotique', 1),
('données', 15),
('données', 16),
('dynamique', 7),
('e_environnement', 20),
('e-commerce', 20),
('envioronnement', 20),
('événementiel:', 17),
('événementiel:', 18),
('Exploration', 15),
('Gamedev', 8),
('Gaming', 5),
('gestion', 3),
('INPT', 9),
('l\'évolution', 7),
('le', 17),
('le', 18),
('les', 7),
('mini-jeux', 5),
('Mining', 15),
('Mobile', 2),
('mobile', 3),
('MRU', 9),
('Partner', 2),
('Personne', 2),
('PFE', 10),
('PFE', 11),
('PFE', 12),
('PFE', 13),
('PFE_INPT', 9),
('Plateforme', 5),
('Réalisation', 17),
('Réalisation', 18),
('rentabilité', 6),
('réseaux', 7),
('Simulateur', 6),
('sociaux', 7),
('Softwalrus', 1),
('Softwalrus', 8),
('SQL', 9),
('Up!', 2),
('Users', 2),
('Utilisateurs', 2),
('web', 7),
('web', 17),
('web', 18),
('web', 25);

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `Nom` varchar(30) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Subject` varchar(400) NOT NULL,
  `Message` varchar(5000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `message`
--

INSERT INTO `message` (`id`, `Nom`, `Email`, `Subject`, `Message`) VALUES
(2, 'KESKES', 'raoufkeskes@gmail.com', 'Sujet', 'Message Testing');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `Titre` varchar(255) NOT NULL,
  `Content` varchar(255) NOT NULL,
  `is_New` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `notification`
--

INSERT INTO `notification` (`id`, `Titre`, `Content`, `is_New`, `created_at`, `user_id`) VALUES
(1, 'Demande Binôme reçue', 'Vous venez de recevoir une Demande binôme de la part de KHABER Fouzi', 0, '2017-05-29 21:56:29', 1),
(2, 'Demande Binôme reçue', 'Vous venez de recevoir une Demande binôme de la part de KESKES Abdelraouf', 1, '2017-05-29 22:00:02', 7),
(3, 'Demande Binôme reçue', 'Vous venez de recevoir une Demande binôme de la part de TOUMI Rafik', 0, '2017-05-29 22:02:38', 1),
(4, 'Demande Binôme reçue', 'Vous venez de recevoir une Demande binôme de la part de LARABI Nacer', 0, '2017-05-30 15:01:07', 1),
(5, 'Demande Binôme refusée', 'Votre Demande binôme a été refusée de la part de : KESKES Abdelraouf', 1, '2017-05-30 15:01:39', 7),
(6, 'Demande Binôme acceptée', 'Votre Demande binôme a été acceptée ! Votre Binôme est : KESKES Abdelraouf', 1, '2017-05-30 15:01:44', 4),
(7, 'Postulation reçue', 'Vous venez de recevoir une postulation pour le sujet : Réalisation d\'une application web dans le domaine événementiel: Application au voyage virtuel de la part de KESKES Abdelraouf', 0, '2017-05-30 20:28:35', 2),
(8, 'Postulation reçue', 'Vous venez de recevoir une postulation pour le sujet : Développement d\'un portail web de la gestion des demandes (BUSINESS) de la part de KESKES Abdelraouf', 0, '2017-05-30 20:28:52', 2),
(9, 'Postulation reçue', 'Vous venez de recevoir une postulation pour le sujet : Conception et réalisation d\'une application mobile dédiée au e-environnement de la part de KESKES Abdelraouf', 0, '2017-05-30 20:31:27', 2),
(10, 'Postulation reçue', 'Vous venez de recevoir une postulation pour le sujet : Conception et implémentation d\'un système patient-pharmacie en Android de la part de KESKES Abdelraouf', 0, '2017-05-30 20:31:31', 2),
(11, 'Promoteur', 'Votre postulation pour le sujet "Conception et réalisation d\'une application mobile dédiée au e-environnement" a été acceptée vous êtes maintenant encadré par : MAHDAOUI Latifa ', 1, '2017-05-30 20:31:56', 4),
(12, 'Promoteur', 'Votre postulation pour le sujet "Conception et réalisation d\'une application mobile dédiée au e-environnement" a été refusée ', 1, '2017-05-30 20:31:56', 4),
(13, 'Promoteur', 'Votre sujet "PFE_INPT" a été encadré par : MAHDAOUI Latifa ', 1, '2017-05-30 20:42:17', 6),
(14, 'Promoteur', 'Votre sujet "PFE_INPT" a été encadré par :   appartenant à Air Algérie', 1, '2017-05-31 00:17:44', 6);

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(65) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

CREATE TABLE `post` (
  `id` int(10) UNSIGNED NOT NULL,
  `Domaine` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Resume` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Workplan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Bibliographie` text COLLATE utf8mb4_unicode_ci,
  `Etat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Oriente` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Recherche & Pratique',
  `NbrAvisFav` int(11) NOT NULL DEFAULT '0',
  `poster_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `post`
--

INSERT INTO `post` (`id`, `Domaine`, `Titre`, `Resume`, `Workplan`, `Bibliographie`, `Etat`, `Type`, `Oriente`, `NbrAvisFav`, `poster_id`, `created_at`, `updated_at`) VALUES
(1, 'Développement Web et Mobile', 'Softwalrus Domotico', 'Le projet consiste à développer un système de domotique commandé par la voix, les gestes, une application Android et possiblement de d\'autres façons. Le projet est d\'automatiser plusieurs processus  qui ne sont généralement pas automatisés à la maison.', 'Le plan de travail : \n- Travail en équipe \n- Tester un plan de travail\n-Un autre point de plan de travail\n-Conclusion du plan de travail', NULL, 'Bloqué', 'interne', 'Recherche & Pratique', 1, 1, '2017-05-29 21:20:26', '2017-05-30 20:31:56'),
(2, 'Développement Web et Mobile', 'Partner Up!', 'Le projet consiste à développer une application mobile qui permettrait aux utilisateurs de trouver d\'autres personnes à proximité pour faire des activités. Par exemple, sur une personne veut trouver une autre personne pour jouer de la guitare, elle pourrait trouver cette personne grâce à notre application.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'Bloqué', 'interne', 'Pratique', 2, 1, '2017-05-29 21:23:08', '2017-05-30 20:31:56'),
(3, 'Développement Web et Mobile', 'Application mobile de gestion de temps', 'Le projet consiste à développer une application mobile, simple d\'utilisation, qui permettrait aux étudiantes et étudiants de l\'Université de Sherbrooke de consulter leur horaire de cours ainsi que de planifier du temps pour les activités nécessaires à leur réussite.\r\n Les résultats attendus sont une application fonctionnelle sur les téléphones Android, iOS et Windows Phone qui se synchronisera automatiquement l\'horaire des cours à partir du CIP des étudiantes et étudiants, qui permettra l\'ajout d\'événements, la catégorisation des événements (sport, études, loisirs, travail, cours, etc.) et qui gérera les horaires par trimestre.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'Bloqué', 'interne', 'Recherche & Pratique', 0, 1, '2017-05-29 21:25:29', '2017-05-30 20:31:56'),
(6, 'Intelligence Artificielle et Méta Heuristiques', 'Simulateur de rentabilité de transactions boursières', 'Le projet consiste à développer une application web servant à simuler des algorithmes boursiers sur des données historiques pour en tester la rentabilité. \r\nRésultats : Les résultats attendus sont une infrastructure qui permet de simuler les revenus potentiels d\'un titre sur une période donné, une interface web permettant de visualiser et d\'analyser les résultats de la simulation, affichage d\'un graphique représentant la courbe des données et des transactions effectuées (jour par jour) et des algorithmes intelligents qui apprennent et évoluent selon les données en entrées avec le temps', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'Bloqué', 'interne', 'Pratique', 0, 1, '2017-05-29 21:32:13', '2017-05-30 20:31:56'),
(5, 'Intelligence Artificielle et Méta Heuristiques', 'Plateforme de mini-jeux', 'Les résultats attendus sont la mise en place d\'une architecture dans Unity capable de choisir et lancer dynamiquement les mini-jeux, une application pour téléphones intelligents les transformant en contrôleurs, capteurs de mouvements et permettre l\'affichage des informations personnalisées à l\'écran, un site web pour accueillir les mini-jeux développés par la communauté, qui permettra de parcourir la bibliothèque de jeux et de les télécharger, des mini-jeux fonctionnels.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'Bloqué', 'interne', 'Pratique', 0, 1, '2017-05-29 21:27:49', '2017-05-30 20:31:56'),
(7, 'Réseaux Sécurité, Réseaux Mobiles et Système d’Exploitation', 'Détection des communautés dans les réseaux sociaux', 'Le projet consiste à construire un outil sous forme de site web qui permettra d\'effectuer différentes tâches (modélisation d\'un réseau social dynamique par un graphe dynamique, détection des communautés et suivi dans le temps, détection des phénomènes de changement qu\'une communauté pourrait subir, visualisation de l\'évolution de ces communautés dans le temps) à partir de données brutes ou d\'instances de graphes dynamiques représentant le réseau social à différent moment dans le temps.\r\n: Les résultats attendus sont un un site web final fonctionnel et capable de présenter les résultats du traitement et de recevoir de grosses quantités de données de façon stable et robuste.', ': Les résultats attendus sont un un site web final fonctionnel et capable de présenter les résultats du traitement et de recevoir de grosses quantités de données de façon stable et robuste.', NULL, 'Bloqué', 'interne', 'Recherche & Pratique', 0, 4, '2017-05-29 21:37:45', '2017-05-30 20:31:56'),
(8, 'Développement Web et Mobile', 'Softwalrus Gamedev', 'Objectifs : Le projet consiste à développer un prototype de jeu respectant des critères donnés par Ubisoft.\r\nMéthode : La méthode utilisée pour réaliser ce projet n\'est pas divulguée.\r\nRésultats : Les résultats attendus sont un prototype de jeu de 10 minutes fonctionnel.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'Bloqué', 'interne', 'Recherche & Pratique', 0, 4, '2017-05-29 21:38:51', '2017-05-30 20:31:56'),
(9, 'Intelligence Artificielle et Méta Heuristiques', 'PFE_INPT', 'Objectifs : Le projet consiste à s\'approprier de nouvelles technologies (ANTLR, String Template, MRU...), améliorer les connaissances en théorie relationnelle, mieux cerner le processus de développement logiciel et approfondir les connaissances en conception, développement et tests de logiciels.\r\nvia  ANTLR, String Template, MRU, SQL\r\nLes résultats attendus sont la réussite des objectifs.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Recherche & Pratique', 0, 6, '2017-05-29 21:41:25', '2017-05-31 00:18:00'),
(10, 'Génie Logiciel, Système d’Information et Base de Données', 'PFE', '(PFE) est un projet complet en situation professionnelle qui marque la fin des études dans une école d\'ingénieurs française. Sa durée est habituellement comprise entre cinq et huit mois.\r\n\r\nLe projet de fin d\'études a pour but de développer l\'autonomie et la responsabilité des étudiants, à créer une dynamique de groupe et l\'esprit d\'un travail collectif et bien sûr à mettre en pratique les enseignements reçus et permettre ainsi aux étudiants d\'affirmer leurs savoir-faire et à considérer leurs compétences.\r\n\r\nCelui-ci peut se dérouler entièrement au sein de l\'entreprise, ou peut nécessiter l\'utilisation du matériel de laboratoire de l\'école. Ceci amène l\'élève ingénieur à alterner les périodes en entreprise et au sein du laboratoire.\r\n\r\nLe Projet de Fin d\'Études est aussi offert dans le cadre de la troisième année du baccalauréat en Loisir, culture et tourisme à l\'Université du Québec à Trois-Rivières.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Recherche', 0, 6, '2017-05-29 21:42:40', '2017-05-31 00:18:00'),
(19, 'Intelligence Artificielle et Méta Heuristiques', 'Réalisation d\'une application web dans le domaine événementiel: Application au voyage virtuel', 'Le marché de la réalité virtuelle est en pleine expansion, notamment dans l’univers des jeux vidéos. Dernièrement le HTC vive a bouleversé le marché, étant considéré comme le casque le plus immersif et réaliste du marché. Ces casques permettent de reproduire un environnement réel (ou imaginaire bien entendu). La réalité augmenté ne se cantonne pas uniquement aux jeux vidéos mais s’étend aussi au domaine du voyage.\r\n\r\nLe voyage virtuel est présent depuis longtemps, très longtemps. Mais vous en êtes-vous déjà rendu compte ? Nous vous assurons que vous avez déjà voyagé virtuellement. La photo, la carte postale, la vidéo sont en effet un genre de voyage virtuel. Bon nous vous l’accordons vous n’étiez pas forcément en total immersion. Les bienfaits du voyage n’étaient pas forcément ressentis avec ces procédés. L’évolution technologique tend à augmenter l’immersion. Par exemple, grâce aux smartphones les photos 360 degrés sont désormais possibles. Google a également créé le projet street view. En quelques clics le monde entier devient accessible. Nous vous conseillons le site Air Pano qui propose des photos 360 justes incroyables. Nous venons d’essayer ça vaut le détour. Voila un des bienfaits du voyage virtuel. Ce qui est intéressant c’est qu’il y a une petite interaction qui ajoute encore plus de plaisir.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Pratique', 0, 2, '2017-05-29 22:07:46', '2017-05-29 22:07:46'),
(20, 'Génie Logiciel, Système d’Information et Base de Données', 'Conception et réalisation d\'une application mobile dédiée au e-environnement', 'The impact of human activities on the environment – and on climate change in particular – are issues of growing concern confronting life on Earth. Concurrently, information and communication technologies (ICTs) are being rapidly deployed around the world. Although ICTs require energy resources, they also offer opportunities to monitor, learn about and protect the environment, reduce carbon emissions, and mitigate climate change.\r\n\r\nITU initiated a bold new work programme in 2008 with its strategy on ICTs and climate change, to ensure that the vital role of ICTs is taken into account in global strategies to address climate change. As part of this strategy, ITU-D Programme 3 is developing reports, toolkits and educational material to raise awareness among its Member States on climate change and the role ICTs can play in combating it.\r\n\r\nThe purpose of Programme 2 (Hyderabad, 2010) is to support the ITU membership in improving access to ICT applications and services, especially in underserved and rural areas, achieving trust and confidence in the use of ICTs, the Internet and next-generation networks, promoting fair and equitable access to critical Internet resources. The activities in the broad area of ICT Applications includes promoting and implementing e-Services and e-Applications (e.g., e-Government, e-Business, e-Learning, e-Health, e-Employment, e-Environment, e-Agriculture, e-Science, etc.) in developing countries. Some related resources can be found below.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Pratique', 0, 2, '2017-05-29 22:10:18', '2017-05-30 20:31:56'),
(21, 'Vision et Imagerie', 'Conception et implémentation d\'un système patient-pharmacie en Android', 'La pharmacie (du grec φάρμακον/pharmakôn signifiant à la fois le remède et le poison) est la science s\'intéressant à la conception, au mode d\'action, à la préparation et à la dispensation des médicaments. Cette dispensation prend en compte les interactions médicamenteuses possibles entre les molécules chimiques ou bien encore, les interactions avec des produits comestibles. Elle permet également la vérification des doses et/ou d\'éventuelles contre-indications. C\'est à la fois une branche de la biologie, de la chimie et de la médecine.\r\n\r\nLe terme pharmacie désigne également une officine, soit un lieu destiné à l\'entreposage et à la dispensation de médicament. Ce lieu est sous la responsabilité d\'un pharmacien qui peut y fabriquer des préparations magistrales ordonnées par un médecin pour un patient donné et superviser le travail des préparateurs en pharmacie en France ou des Assistants techniques en pharmacie au Canada. La dispensation des médicaments dans une officine de pharmacie se fait sous l\'entière responsabilité du pharmacien, que ce soient des médicaments délivrés sur prescription médicale ou non.\r\n\r\nAu sein de l\'officine, le pharmacien peut également faire le suivi de la médication du patient, substituer un princeps (ou médicament original) par un générique, adapter les posologies, renouveler les traitements des pathologies chroniques et proposer des modifications de thérapeutique en accord avec le médecin. Un dialogue entre ces deux professionnels de santé est essentiel à la santé publique.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Pratique', 0, 2, '2017-05-29 22:11:57', '2017-05-30 20:31:56'),
(14, 'Intelligence Artificielle et Méta Heuristiques', 'Big data', 'Le big data, littéralement « grosses données », ou mégadonnées (recommandé3), parfois appelées données massives4, désignent des ensembles de données qui deviennent tellement volumineux qu\'ils en deviennent difficiles à travailler avec des outils classiques de gestion de base de données ou de gestion de l\'information.\r\n\r\nL’explosion quantitative (et souvent redondante) de la donnée numérique contraint à de nouvelles manières de voir et analyser le monde5. De nouveaux ordres de grandeur concernent la capture, le stockage, la recherche, le partage, l\'analyse et la visualisation des données. Les perspectives du traitement des big data sont énormes et en partie encore insoupçonnées ; on évoque souvent de nouvelles possibilités d\'exploration de l\'information diffusée par les médias6, de connaissance et d\'évaluation, d\'analyse tendancielle et prospective (climatiques, environnementales ou encore sociopolitiques, etc.) et de gestion des risques (commerciaux, assuranciels, industriels, naturels) et de phénomènes religieux, culturels, politiques7, mais aussi en termes de génomique ou métagénomique8, pour la médecine (compréhension du fonctionnement du cerveau, épidémiologie, écoépidémiologie...), la météorologie et l\'adaptation aux changements climatiques, la gestion de réseaux énergétiques complexes (via les smartgrids ou un futur « internet de l\'énergie »), l\'écologie (fonctionnement et dysfonctionnement des réseaux écologiques, des réseaux trophiques avec le GBIF par exemple), ou encore la sécurité et la lutte contre la criminalité9. La multiplicité de ces applications laisse d\'ailleurs déjà poindre un véritable écosystème économique impliquant, d\'ores et déjà, les plus gros joueurs du secteur des technologies de l\'information10.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Recherche', 0, 6, '2017-05-29 21:46:36', '2017-05-31 00:18:00'),
(15, 'Intelligence Artificielle et Méta Heuristiques', 'Exploration de données', 'L’exploration de donnéesnotes 1, connue aussi sous l\'expression de fouille de données, forage de données, prospection de données, data mining, ou encore extraction de connaissances à partir de données, a pour objet l’extraction d\'un savoir ou d\'une connaissance à partir de grandes quantités de données, par des méthodes automatiques ou semi-automatiques.\r\n\r\nElle se propose d\'utiliser un ensemble d\'algorithmes issus de disciplines scientifiques diverses telles que les statistiques, l\'intelligence artificielle ou l\'informatique, pour construire des modèles à partir des données, c\'est-à-dire trouver des structures intéressantes ou des motifs selon des critères fixés au préalable, et d\'en extraire un maximum de connaissances.\r\n\r\nL\'utilisation industrielle ou opérationnelle de ce savoir dans le monde professionnel permet de résoudre des problèmes très divers, allant de la gestion de la relation client à la maintenance préventive, en passant par la détection de fraudes ou encore l\'optimisation de sites web. C\'est aussi le mode de travail du journalisme de données1.\r\n\r\nL\'exploration de données2 fait suite, dans l\'escalade de l\'exploitation des données de l\'entreprise, à l\'informatique décisionnelle. Celle-ci permet de constater un fait, tel que le chiffre d\'affaires, et de l\'expliquer comme le chiffre d\'affaires décliné par produits, tandis que l\'exploration de données permet de classer les faits et de les prévoir dans une certaine mesure notes 2 ou encore de les éclairer en révélant par exemple les variables ou paramètres qui pourraient faire comprendre pourquoi le chiffre d\'affaires de tel point de vente est supérieur à celui de tel autre.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Pratique', 0, 7, '2017-05-29 21:48:57', '2017-05-29 21:56:00'),
(16, 'Intelligence Artificielle et Méta Heuristiques', 'Analyse des données', 'L’analyse des données est une famille de méthodes statistiques dont les principales caractéristiques sont d\'être multidimensionnelles et descriptives. Certaines méthodes, pour la plupart géométriques, aident à faire ressortir les relations pouvant exister entre les différentes données et à en tirer une information statistique qui permet de décrire de façon plus succincte les principales informations contenues dans ces données. D\'autres techniques permettent de regrouper les données de façon à faire apparaître clairement ce qui les rend homogènes, et ainsi mieux les connaître.\r\n\r\nL’analyse des données permet de traiter un nombre très important de données et de dégager les aspects les plus intéressants de la structure de celles-ci. Le succès de cette discipline dans les dernières années est dû, dans une large mesure, aux représentations graphiques fournies. Ces graphiques peuvent mettre en évidence des relations difficilement saisies par l’analyse directe des données ; mais surtout, ces représentations ne sont pas liées à une opinion « a priori » sur les lois des phénomènes analysés contrairement aux méthodes de la statistique classique.\r\n\r\nLes fondements mathématiques de l’analyse des données ont commencé à se développer au début du xxe siècle, mais ce sont les ordinateurs qui ont rendu cette discipline opérationnelle, et qui en ont permis une utilisation très étendue. Mathématiques et informatique sont ici intimement liées.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Recherche', 0, 7, '2017-05-29 21:54:33', '2017-05-29 21:54:33'),
(22, 'Développement Web et Mobile', 'Développement d\'un portail web de la gestion des demandes (BUSINESS)', 'Ooredoo (Qtel pour Qatar Telecom jusqu\'en mars 2013) est une société de télécommunication d\'origine qatarie. Elle possède plusieurs participations dans Wataniya Telecom, Nawras, Tunisiana, Asiacell, Indosat. La société est présente au Moyen-Orient, en Europe et en Asie, incluant l\'Algérie, l\'Indonésie, l\'Irak, le Koweït, le Myanmar, les Maldives, Oman, la Palestine, le Qatar et la Tunisie. Ooredoo a publié dans un communiqué avoir plus de 114 millions de clients en septembre 20153.\r\n\r\nLes actions de Ooredoo sont inscrites à la bourse du Qatar et a l\'Abu Dhabi Securities Exchange4.', 'Ooredoo (Qtel pour Qatar Telecom jusqu\'en mars 2013) est une société de télécommunication d\'origine qatarie. Elle possède plusieurs participations dans Wataniya Telecom, Nawras, Tunisiana, Asiacell, Indosat. La société est présente au Moyen-Orient, en Europe et en Asie, incluant l\'Algérie, l\'Indonésie, l\'Irak, le Koweït, le Myanmar, les Maldives, Oman, la Palestine, le Qatar et la Tunisie. Ooredoo a publié dans un communiqué avoir plus de 114 millions de clients en septembre 20153.\r\n\r\nLes actions de Ooredoo sont inscrites à la bourse du Qatar et a l\'Abu Dhabi Securities Exchange4.', NULL, 'En candidature', 'interne', 'Pratique', 0, 2, '2017-05-29 22:14:13', '2017-05-29 22:14:13'),
(23, 'Génie Logiciel, Système d’Information et Base de Données', 'Conception et réalisation d\'un système d\'information pour la gestion de la bibliothèque du Département Informatique', 'Une bibliothèque (du grec ancien βιβλιοθήκη : biblio, « livre » ; thêkê, « place ») est le lieu où est conservée et lue une collection organisée de livres. Il existe des bibliothèques privées (y compris de riches bibliothèques ouvertes au public) et des bibliothèques publiques. Les bibliothèques proposent souvent d\'autres documents (journaux, périodiques, enregistrements sonores, enregistrements vidéo, cartes et plans, partitions) ainsi que des accès à internet et sont parfois appelées médiathèques ou informathèques.\r\n\r\nLa majorité des bibliothèques (municipales, universitaires) autorisent le prêt de leurs documents gratuitement ; d\'autres (la Bibliothèque publique d\'information notamment) leur consultation sur place seulement. Elles peuvent alors être divisées en salles de lectures, ouvertes au public, et en magasins bibliothéquaires, fermés, pour le stockage de livres moins consultés. D\'autres espaces, ouverts ou non au public, peuvent s\'ajouter.\r\n\r\nEn 2010, avec plus de 144,5 millions de documents, dont 21,8 millions de livres, la plus grande bibliothèque du monde est la bibliothèque du Congrès à Washington D.C.. Néanmoins, la collection cumulée de livres des deux bibliothèques nationales russes atteint 32,5 millions de volumes et la collection de la British Library 150 millions d\'articles.', 'Le plan de travail : \r\n- Travail en équipe \r\n- Tester un plan de travail\r\n-Un autre point de plan de travail\r\n-Conclusion du plan de travail', NULL, 'En candidature', 'interne', 'Pratique', 0, 5, '2017-05-29 22:19:08', '2017-05-29 22:19:49'),
(24, 'Génie Logiciel, Système d’Information et Base de Données', 'Mise en oeuvre d\'une BDG pour l\'analyse du crime de vol dans une localité', 'On peut alors aujourd’hui regrouper la cybercriminalité en trois types d’infractions :\r\n\r\nles infractions spécifiques aux technologies de l’information et de la communication : parmi ces infractions, on recense les atteintes aux systèmes de traitement automatisé de données, les traitements non autorisés de données personnelles (comme la cession illicite des informations personnelles), les infractions aux cartes bancaires, les chiffrements non autorisés ou non déclarés ou encore les interceptions ;\r\nles infractions liées aux technologies de l’information et de la communication : cette catégorie regroupe la pédopornographie, l’incitation au terrorisme et à la haine raciale sur internet, les atteintes aux personnes privées et non aux personnages publics, les atteintes aux biens ;\r\nles infractions facilitées par les technologies de l’information et de la communication, que sont les escroqueries en ligne, le blanchiment d\'argent, la contrefaçon ou toute autre violation de propriété intellectuelle.', 'On peut alors aujourd’hui regrouper la cybercriminalité en trois types d’infractions :\r\n\r\nles infractions spécifiques aux technologies de l’information et de la communication : parmi ces infractions, on recense les atteintes aux systèmes de traitement automatisé de données, les traitements non autorisés de données personnelles (comme la cession illicite des informations personnelles), les infractions aux cartes bancaires, les chiffrements non autorisés ou non déclarés ou encore les interceptions ;\r\nles infractions liées aux technologies de l’information et de la communication : cette catégorie regroupe la pédopornographie, l’incitation au terrorisme et à la haine raciale sur internet, les atteintes aux personnes privées et non aux personnages publics, les atteintes aux biens ;\r\nles infractions facilitées par les technologies de l’information et de la communication, que sont les escroqueries en ligne, le blanchiment d\'argent, la contrefaçon ou toute autre violation de propriété intellectuelle.', NULL, 'En candidature', 'interne', 'Recherche', 0, 5, '2017-05-29 22:21:02', '2017-05-29 22:21:02'),
(25, 'Intelligence Artificielle et Méta Heuristiques', 'Titre', 'résumé', 'aaaaa', NULL, 'En candidature', 'externe', 'Recherche', 0, 9, '2017-05-30 14:58:42', '2017-05-30 14:58:42');

-- --------------------------------------------------------

--
-- Structure de la table `postule`
--

CREATE TABLE `postule` (
  `student_id` int(10) UNSIGNED NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `is_Blocked` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `postule`
--

INSERT INTO `postule` (`student_id`, `post_id`, `is_Blocked`, `created_at`) VALUES
(1, 21, 1, '2017-05-30 20:31:31');

-- --------------------------------------------------------

--
-- Structure de la table `post_specialite`
--

CREATE TABLE `post_specialite` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `specialite_id` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `post_specialite`
--

INSERT INTO `post_specialite` (`post_id`, `specialite_id`) VALUES
(1, 'ISIL'),
(2, 'ISIL'),
(5, 'ISIL'),
(7, 'ISIL'),
(8, 'ISIL'),
(9, 'ACAD'),
(13, 'ACAD'),
(14, 'ACAD'),
(16, 'SII'),
(19, 'ACAD'),
(19, 'IL'),
(19, 'ISIL'),
(19, 'RSD'),
(21, 'ACAD'),
(21, 'APCI'),
(21, 'GTR'),
(21, 'IL'),
(21, 'INFVIS'),
(21, 'ISIL'),
(21, 'MIND'),
(21, 'RSD'),
(21, 'SII'),
(21, 'SSI'),
(23, 'ACAD'),
(23, 'GTR'),
(23, 'ISIL'),
(24, 'IL'),
(24, 'RSD'),
(24, 'SII'),
(24, 'SSI'),
(25, 'ACAD'),
(25, 'GTR'),
(25, 'ISIL');

-- --------------------------------------------------------

--
-- Structure de la table `representant`
--

CREATE TABLE `representant` (
  `id` int(10) UNSIGNED NOT NULL,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Grade` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Profession` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Service` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `representant`
--

INSERT INTO `representant` (`id`, `Nom`, `Prenom`, `Grade`, `Profession`, `Service`, `company_id`, `created_at`, `updated_at`) VALUES
(1, 'test', 'aaaaaaa', 'a', 'a', 'aaaaaaaaaaaaaa', 1, '2017-05-31 00:17:44', '2017-05-31 00:17:44');

-- --------------------------------------------------------

--
-- Structure de la table `specialite`
--

CREATE TABLE `specialite` (
  `spec` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `niveau` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `specialite`
--

INSERT INTO `specialite` (`spec`, `niveau`, `label`) VALUES
('ISIL', 'Licence', 'Ingénierie des Systèmes d\'Information et des Logiciels'),
('ACAD', 'Licence', 'Informatique Académique'),
('GTR', 'Licence', 'Génie des Télécommunications et Réseaux'),
('RSD', 'Master', 'Réseaux et Systèmes Distribués'),
('IL', 'Master', 'Ingénierie du Logiciel'),
('SII', 'Master', 'Systèmes Informatiques Intelligents'),
('SSI', 'Master', 'Sécurité des Systèmes Informatiques'),
('APCI', 'Master', 'Architectures Parallèles et Calcul Intensif'),
('MIND', 'Master', 'Mathématiques et Informatique Décisionnelle'),
('INFVIS', 'Master', 'Master Informatique Visuelle');

-- --------------------------------------------------------

--
-- Structure de la table `student`
--

CREATE TABLE `student` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Matricule` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `specialite` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Binome_id` int(10) UNSIGNED DEFAULT NULL,
  `AcceptedPost_id` int(10) UNSIGNED DEFAULT NULL,
  `Promoteur_interne_id` int(10) UNSIGNED DEFAULT NULL,
  `Promoteur_externe_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `student`
--

INSERT INTO `student` (`id`, `created_at`, `updated_at`, `Matricule`, `Nom`, `Prenom`, `specialite`, `Binome_id`, `AcceptedPost_id`, `Promoteur_interne_id`, `Promoteur_externe_id`) VALUES
(1, '2017-05-29 20:46:14', '2017-05-30 20:31:56', '201400007578', 'KESKES', 'Abdelraouf', 'ISIL', 2, 20, 1, NULL),
(2, '2017-05-29 21:00:49', '2017-05-30 20:31:56', '201400007577', 'LARABI', 'Nacer', 'ISIL', 1, 20, 1, NULL),
(3, '2017-05-29 21:04:19', '2017-05-31 00:18:00', '201400008595', 'TOUMI', 'Rafik', 'ACAD', NULL, NULL, NULL, NULL),
(4, '2017-05-29 21:05:46', '2017-05-29 21:05:46', '201400004758', 'KHABER', 'Fouzi', 'SII', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `teacher`
--

CREATE TABLE `teacher` (
  `id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Grade` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Profession` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commission_de_validation_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `teacher`
--

INSERT INTO `teacher` (`id`, `created_at`, `updated_at`, `Nom`, `Prenom`, `Grade`, `Profession`, `commission_de_validation_id`) VALUES
(1, '2017-05-29 20:55:11', '2017-05-30 10:31:36', 'MAHDAOUI', 'Latifa', 'MCA', 'Enseignante', 1),
(2, '2017-05-29 21:02:53', '2017-05-29 21:02:53', 'DOUADI', 'Mohamed', 'AT', 'Chercheur', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Telephone` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_Activated` tinyint(1) NOT NULL DEFAULT '0',
  `is_Approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_Completed` tinyint(1) NOT NULL DEFAULT '0',
  `userable_id` int(11) DEFAULT NULL,
  `userable_type` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `Telephone`, `is_Activated`, `is_Approved`, `is_Completed`, `userable_id`, `userable_type`, `token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'raoufkeskes', 'raoufkeskes@gmail.com', '$2y$10$YWFe5rbbaecKzfrYavWQTOtEddg3nhpFcT9nBcEve5cjeaeieoYnG', '0551822162', 1, 1, 0, 1, 'Student', '', '9DThRobUK97xqAOwRpLcVVdqCyLw6NCiP5YNCdSP5rlD9d1TYwyqL0UxJ16D', '2017-05-29 20:46:14', '2017-05-30 10:08:21'),
(2, 'latifamahdaoui', 'mehdaoui@test.com', '$2y$10$/oQSj5PCD3kF3qOn16chUu.2VEtiVsGJcxmfEf5E30HIqyK2SDmaO', '0551000001', 1, 1, 0, 1, 'Teacher', '4rMauTGx35cv9XSKMBg19H2k2', 'oB9mKijzebt1Tsx58dyzcFHAzfH308VrhhWR5z8FTlkvjeKJ2lZjLJTIwZAC', '2017-05-29 20:55:11', '2017-05-29 20:55:11'),
(3, 'airalgerie', 'airalgerie@test.com', '$2y$10$Al.8na1HjSU9kexXFmL1VO1p6K62izPBU0BRtwG1QumOOXCQokSMq', '021000002', 1, 1, 0, 1, 'Company', 'bwuUmrNAQOBgFrrsOr8DE2WKN', 'R61a7ebXLwk4SkSpIbsFIdJp0aVgHcUm4FPeEKxjLWgMPDtDHNenLT0OgVKa', '2017-05-29 20:57:43', '2017-05-29 20:57:43'),
(4, 'larabinacer', 'larabinacer@test.com', '$2y$10$o3n8MkHKIDUa19R1U2/LIucUMsDpQMbv/h9liSG7wOaVwqTOaqiqe', '0551822101', 1, 1, 0, 2, 'Student', 'l4ueCdBjTst1BpyTy8GDu9P7H', 'QdTQRTXQ6aBx6a2zYtNcgjIamiPOE6xUag9AkwcB9PvUjkfaXPrF1RCmc0WA', '2017-05-29 21:00:49', '2017-05-29 21:00:49'),
(5, 'djouadimohamed', 'djouadi.mohammed@test.com', '$2y$10$hD32dGZpke5ReCDLFh/2gOuW2FKrrrXuQhkDLL5NKo9KI5px0cyIq', '0551000004', 1, 1, 0, 2, 'Teacher', 'WgdNvJcLip4Bxgj89wKpwVCvw', 'aMU0yrmX3aV4ofpTDjHgSxwYHdvh5dbdp5v4Qz1qoogJxxLILfd6gFqGLp3A', '2017-05-29 21:02:53', '2017-05-29 21:02:53'),
(6, 'rafiktoumi', 'rafiktoumi@gmail.com', '$2y$10$z3xdgx9fy5JluABUpHxQ4Odp/daiMhkrwXBE.LumfApqrYJsMeN8i', '0550112233', 1, 1, 0, 3, 'Student', 'iV91vEietbpz20dzmRQrMrhRo', 'GhdEeDjyqDKc75iMQT2ffcbAVe20R1ZoELuDcKyk7SOMVkucZS5TGy3DMRYp', '2017-05-29 21:04:19', '2017-05-29 21:04:19'),
(7, 'fouzi_khaber', 'fouzi_khaber@gmail.tes', '$2y$10$UGMry0oudbDRFYylRaib0u8lJsfaM0UhSeWUfLZcs.Xqvou7ihY4S', '0660000001', 1, 1, 0, 4, 'Student', 'q1lPfTHc3V5A4OJ1b5u9eW1SD', 'VEx92exCnFZ2Gg96q2FvgcquG07U5VTLQwrfwM5is7bfTFLFCTwevY4pRi3Q', '2017-05-29 21:05:46', '2017-05-29 21:05:46'),
(9, 'elite_company', 'boitedessaipfe@gmail.com', '$2y$10$GO19h9At983m76sIYctbMOrIjkDlh4tvwSVo57Wi2N31IYwk8ov4i', '021323241', 1, 1, 0, 3, 'Company', '', 'wksk10XLUhunVb0X96oXonoLQcNzDv0jiOKPnQu1CDWfWauhzTSWJwKg3hnA', '2017-05-30 14:54:07', '2017-05-30 14:55:54');

-- --------------------------------------------------------

--
-- Structure de la table `user_password_resets`
--

CREATE TABLE `user_password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `valide`
--

CREATE TABLE `valide` (
  `post_id` int(10) UNSIGNED NOT NULL,
  `teacher_id` int(10) UNSIGNED NOT NULL,
  `Reserve` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Contenu de la table `valide`
--

INSERT INTO `valide` (`post_id`, `teacher_id`, `Reserve`, `created_at`, `updated_at`) VALUES
(2, 1, 'Hellllloo  Testing Reserve', NULL, NULL);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `annee_universitaire`
--
ALTER TABLE `annee_universitaire`
  ADD PRIMARY KEY (`annee`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comment_post_id_foreign` (`post_id`),
  ADD KEY `comment_user_id_foreign` (`user_id`);

--
-- Index pour la table `commission_de_validation`
--
ALTER TABLE `commission_de_validation`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_raison_sociale_unique` (`Raison_sociale`);

--
-- Index pour la table `cursus`
--
ALTER TABLE `cursus`
  ADD PRIMARY KEY (`student_id`,`annee_universitaire_id`),
  ADD KEY `annee_universitaire_id` (`annee_universitaire_id`);

--
-- Index pour la table `deadline`
--
ALTER TABLE `deadline`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `demande_binome`
--
ALTER TABLE `demande_binome`
  ADD PRIMARY KEY (`Student1_id`,`Student2_id`),
  ADD KEY `Student2_id` (`Student2_id`);

--
-- Index pour la table `keyword`
--
ALTER TABLE `keyword`
  ADD PRIMARY KEY (`keyword`);

--
-- Index pour la table `keyword_post`
--
ALTER TABLE `keyword_post`
  ADD PRIMARY KEY (`keyword_id`,`post_id`),
  ADD KEY `keyword_post_post_id_foreign` (`post_id`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `User_key` (`user_id`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Index pour la table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_poster_id_foreign` (`poster_id`);

--
-- Index pour la table `postule`
--
ALTER TABLE `postule`
  ADD PRIMARY KEY (`student_id`,`post_id`),
  ADD KEY `postule_post_id_foreign` (`post_id`);

--
-- Index pour la table `post_specialite`
--
ALTER TABLE `post_specialite`
  ADD PRIMARY KEY (`post_id`,`specialite_id`),
  ADD KEY `post_specialite_specialite_id_foreign` (`specialite_id`);

--
-- Index pour la table `representant`
--
ALTER TABLE `representant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `representant_company_id_foreign` (`company_id`);

--
-- Index pour la table `specialite`
--
ALTER TABLE `specialite`
  ADD PRIMARY KEY (`spec`);

--
-- Index pour la table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_matricule_unique` (`Matricule`),
  ADD KEY `student_binome_id_foreign` (`Binome_id`),
  ADD KEY `student_specialite_foreign` (`specialite`),
  ADD KEY `student_promoteur_interne_id_foreign` (`Promoteur_interne_id`),
  ADD KEY `student_promoteur_externe_id_foreign` (`Promoteur_externe_id`),
  ADD KEY `student_acceptedpost_id_foreign` (`AcceptedPost_id`);

--
-- Index pour la table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_commission_de_validation_id_foreign` (`commission_de_validation_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_username_unique` (`username`),
  ADD UNIQUE KEY `user_email_unique` (`email`);

--
-- Index pour la table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  ADD KEY `user_password_resets_email_index` (`email`),
  ADD KEY `user_password_resets_token_index` (`token`);

--
-- Index pour la table `valide`
--
ALTER TABLE `valide`
  ADD PRIMARY KEY (`post_id`,`teacher_id`),
  ADD KEY `valide_teacher_id_foreign` (`teacher_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `commission_de_validation`
--
ALTER TABLE `commission_de_validation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `deadline`
--
ALTER TABLE `deadline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT pour la table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT pour la table `representant`
--
ALTER TABLE `representant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
