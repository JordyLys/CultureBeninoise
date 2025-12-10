<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contenu;
use Carbon\Carbon;

class ContenuSeeder extends Seeder
{
    public function run(): void
    {
        // Auteurs (role 1 uniquement)
        $auteurs = [2, 3, 5, 6];

        // Modérateurs (role 3 uniquement)
        $moderateurs = [4];

        // Types de contenu disponibles
        $typesContenu = [
            1 => 'Histoire',
            2 => 'Conte',
            3 => 'Recette',
            4 => 'Rituel'
        ];

        $contenus = [
            [
                'titre' => 'Origine du Danxomɛ',
                'texte' => 'Le Danxome, dans la culture fon de l’actuel Bénin, occupe une place particulière dans le tissu social et spirituel des communautés. Son origine est intimement liée aux croyances ancestrales et aux pratiques rituelles des peuples fon, qui considèrent la danse comme un vecteur de communication entre le monde des vivants et celui des esprits. Le mot « Danxome » lui-même provient de la combinaison de deux termes en langue fongbé : « Dan » signifiant « danse » et « Xome » désignant un espace sacré ou un lieu de réunion rituel. Ainsi, le Danxome est littéralement « la danse dans l’espace sacré », et ce sens dépasse largement la simple notion de mouvement corporel ou de divertissement.

L’histoire du Danxome remonte à plusieurs siècles, bien avant la colonisation européenne, dans les royaumes de Abomey et de Porto-Novo. Il était alors étroitement associé aux cérémonies religieuses du vodoun, la religion traditionnelle des Fon. Chaque village ou quartier possédait son propre type de Danxome, avec des rythmes et des costumes distincts, reflétant les divinités locales appelées Vodoun. Par exemple, le Danxome dédié à Legba, le gardien des carrefours et des communications, se caractérisait par des pas rapides et précis, accompagnés du tambour tché et du xylophone en bois appelé gankogui. Cette danse servait à honorer l’esprit, à demander protection et guidance, et parfois à résoudre des conflits au sein de la communauté.

L’origine du Danxome est également liée aux récits oraux et aux mythes fon. Selon certaines traditions, le premier Danxome fut créé par un ancien roi ou un grand prêtre qui voulait célébrer la victoire d’une guerre ou la prospérité d’une récolte. La danse devenait alors un symbole de gratitude envers les ancêtres et les esprits, et sa pratique était codifiée par des règles strictes : seuls certains membres de la communauté, souvent les initiés au vodoun, pouvaient exécuter les mouvements sacrés. Les gestes du Danxome ne sont jamais anodins ; chaque mouvement a une signification précise : lever la main droite peut symboliser un appel aux esprits protecteurs, tandis qu’un pas circulaire représente la continuité de la vie et l’harmonie entre les générations.

Au fil des siècles, le Danxome a évolué pour devenir un élément central de la vie sociale. Il ne se limite plus aux rites religieux, mais s’invite aussi dans les mariages, les funérailles et les fêtes de récolte. Les anciens transmettaient le savoir de génération en génération par l’observation et la répétition, et les jeunes apprenaient à maîtriser le rythme, la posture et la coordination avec les tambours. Cette transmission orale est fondamentale, car elle permet de préserver l’authenticité et l’essence spirituelle de la danse.

Avec l’arrivée des influences extérieures, notamment la colonisation et la diffusion du christianisme, le Danxome a subi des transformations. Certains aspects strictement rituels ont été adaptés ou remplacés par des formes plus spectaculaires destinées au divertissement et aux festivals culturels. Cependant, les Fon attachent toujours une grande importance à la dimension sacrée de la danse, et dans de nombreux villages, elle reste un pont entre le passé et le présent, entre le monde visible et l’invisible.

En somme, l’origine du Danxome en Fongbé Dépêche est un mélange riche de spiritualité, de tradition et de créativité sociale. Cette danse sacrée incarne non seulement l’identité culturelle des Fon, mais aussi leur manière de percevoir le monde, d’honorer les ancêtres et de transmettre des valeurs essentielles. Étudier le Danxome, c’est plonger dans l’histoire vivante d’un peuple qui continue, à travers le rythme et le mouvement, à célébrer la vie, la mémoire et la spiritualité.',
                'idRegion' => 1, 'idLangue' => 6, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'La légende de Tê Agbanlin',
                'texte' => 'La légende de Tê Agbanlin est profondément ancrée dans l’imaginaire et la tradition des peuples fon du Bénin. Elle raconte l’histoire d’un héros mythique, dont le nom signifie littéralement « celui qui ouvre la porte du village » ou « le gardien du passage ». Ce personnage est souvent associé à la bravoure, à la sagesse et à la protection de la communauté. La légende a été transmise oralement de génération en génération et demeure un symbole de courage et de vigilance pour les habitants de certaines régions de l’ancien royaume d’Abomey.

Selon la tradition, Tê Agbanlin était un jeune homme exceptionnel dès sa naissance. On raconte que sa mère l’avait porté pendant une longue période et qu’à sa naissance, il avait montré des signes de force et de clairvoyance inhabituels. Dès son enfance, il se distingua par son intelligence et sa capacité à comprendre les esprits de la nature, les ancêtres et les forces invisibles qui régissent le monde. Les anciens du village voyaient en lui un élu des dieux, destiné à accomplir de grandes choses pour protéger et guider son peuple.

La légende raconte qu’un jour, un danger menaça le village : des ennemis venant d’une contrée lointaine s’apprêtaient à attaquer la communauté. Les habitants étaient terrifiés et ne savaient pas comment défendre leurs maisons et leurs terres. Tê Agbanlin, encore jeune mais doté d’une sagesse surprenante, décida d’agir. Il entreprit un long voyage dans la forêt sacrée pour consulter les esprits et obtenir leur aide. Là, il rencontra des forces mystérieuses qui lui confièrent des pouvoirs extraordinaires : la force surhumaine, la capacité de comprendre les animaux et de prédire les mouvements des ennemis.

Avec ces pouvoirs, Tê Agbanlin retourna au village et mit en place une stratégie ingénieuse pour protéger ses habitants. Il guida les villageois à travers des pièges et des embuscades, utilisant son intelligence autant que sa force physique. Les ennemis furent surpris et incapables de comprendre les mouvements de ce jeune héros, et ils furent finalement repoussés. Ce succès fit de Tê Agbanlin un héros respecté et admiré, non seulement pour sa bravoure, mais aussi pour sa sagesse et son sens du devoir envers la communauté.

Au-delà de l’aspect guerrier, la légende de Tê Agbanlin comporte aussi des enseignements moraux et sociaux. Elle illustre l’importance de la solidarité, du respect des anciens et de l’écoute des forces invisibles. Tê Agbanlin est souvent présenté comme un médiateur entre le monde des humains et celui des esprits, un lien vivant entre les traditions ancestrales et la vie quotidienne des habitants. Sa figure rappelle que la protection d’une communauté ne repose pas seulement sur la force, mais aussi sur la réflexion, la ruse et l’harmonie avec la nature.

Avec le temps, la légende a pris différentes formes dans les récits oraux et les cérémonies traditionnelles. Dans certaines versions, Tê Agbanlin est devenu un personnage presque surnaturel, capable de métamorphoses et de miracles. Dans d’autres, il incarne surtout le courage humain et la détermination. Les enfants des villages apprennent son histoire dès le plus jeune âge, et ses exploits sont souvent célébrés lors de danses, de chants et de festivals, renforçant le lien culturel entre les générations et entre les vivants et les ancêtres.

En somme, Tê Agbanlin n’est pas seulement un héros légendaire ; il est un symbole vivant de la force, de la sagesse et de la protection dans la culture fon. Sa légende continue d’inspirer et de guider les communautés, rappelant que le courage et la vigilance sont essentiels pour surmonter les dangers et préserver l’harmonie au sein du village. Ainsi, à travers les siècles, Tê Agbanlin demeure un pilier du patrimoine culturel et spirituel du Bénin, un héros intemporel dont la légende traverse le temps.',
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 2,
            ],
            [
                'titre' => 'Rituel Vodun Sakpata',
                'texte' => 'Le rituel Vodoun Sakpate est l’un des plus puissants et symboliques dans la tradition vodoun du Bénin. Sakpate est considéré comme le loa ou esprit de la terre et de la mort. Il est le gardien des secrets du monde souterrain, celui qui relie les vivants aux ancêtres et aux forces invisibles. Dans la cosmologie vodoun, Sakpate incarne à la fois la rigueur et la protection : il punit ceux qui ne respectent pas les lois ancestrales mais bénit ceux qui honorent correctement ses rites.

Le rituel Sakpate est généralement exécuté dans un espace sacré, souvent dans la forêt ou dans un sanctuaire spécifique, entouré de symboles de la terre : calebasses, terres rouges, cauris, et objets funéraires. L’officiant principal, souvent un prêtre ou un prêtre initié, prépare l’autel en disposant les offrandes et en traçant des signes sacrés au sol. Les offrandes comprennent généralement du maïs, du mil, du vin de palme, de l’eau et parfois des volailles, destinées à apaiser l’esprit et à solliciter sa protection.

Les participants au rituel chantent et dansent au son des tambours sacrés. Chaque rythme est codifié : certains rythmes évoquent la force et la rigueur de Sakpate, d’autres sa capacité à purifier et protéger. La transe est une partie intégrante du rituel : les initiés et certains participants entrent dans un état où ils deviennent des canaux pour l’esprit, permettant à Sakpate de communiquer ses conseils ou avertissements.

Le rituel Sakpate peut être exécuté à différents moments : pour protéger un village, pour bénir une nouvelle plantation, ou pour obtenir la guidance spirituelle sur des questions cruciales comme la santé, le mariage ou les conflits. C’est un rituel qui demande beaucoup de préparation, de respect des codes ancestraux et de concentration. Il est considéré comme sacré et ne peut être exécuté que par ceux qui ont été correctement initiés.

Sakpate rappelle aux communautés la nécessité de respecter la terre, les ancêtres et les lois spirituelles. Son rituel n’est pas seulement religieux, il est aussi un moyen de maintenir l’harmonie sociale et d’assurer la cohésion de la communauté. C’est un exemple puissant de la façon dont le vodoun structure la vie collective au Bénin, mêlant spiritualité, tradition et lien avec la nature.',
                'idRegion' => 1, 'idLangue' => 6, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Recette traditionnelle du Wassa-Wassa',
                'texte' => 'Le Wassa Wassa est une spécialité culinaire traditionnelle du Bénin, particulièrement dans les régions du Sud. Il s’agit d’un plat à base de farine de maïs ou de mil, cuit à la vapeur et souvent servi avec une sauce aux légumes ou au poisson. La préparation du Wassa Wassa est à la fois un geste culinaire et culturel : elle rassemble souvent la famille et respecte un savoir-faire transmis depuis plusieurs générations.

Pour préparer le Wassa Wassa, on commence par tamiser la farine pour éliminer les impuretés. La farine est ensuite mélangée à de l’eau tiède jusqu’à obtenir une pâte lisse et homogène. Dans certaines régions, on ajoute un peu de sel ou des feuilles pilées pour aromatiser. La pâte est ensuite enveloppée dans des feuilles de bananier ou de manioc, formant des petits paquets, avant d’être cuite à la vapeur dans une marmite traditionnelle.

La cuisson du Wassa Wassa demande de la patience : la vapeur doit pénétrer la pâte lentement pour obtenir une consistance ferme mais moelleuse. Pendant ce temps, la sauce qui l’accompagne est préparée avec soin. Les sauces les plus courantes incluent le gombo, l’oseille, l’arachide ou le poisson fumé. Les épices locales comme le piment, le gingembre et l’ail apportent la saveur caractéristique du plat.

Le Wassa Wassa est plus qu’un simple repas ; il est un symbole de partage et de convivialité. Lors des fêtes ou des cérémonies traditionnelles, il est souvent préparé en grande quantité pour nourrir tous les participants. La préparation collective de ce plat renforce les liens familiaux et communautaires, et le geste de servir le Wassa Wassa aux invités est un signe de respect et d’hospitalité.',
                'idRegion' => 4, 'idLangue' => 6, 'idTypeContenu' => 3,
            ],
            [
                'titre' => 'Gaani rɛ̀nɛ̀',
                'texte' => '
Gaani rɛ̀nɛ̀ wé do nɔ̀ gɛ̀nɛ̀ si Bariba tɔ̀gɔ̀nɛ̀. Wé do nɔ̀ nu kpɔn, wé kpɔn kpɔn nɔ̀ hɛn tɔ́, wé kpɔn kpɔn nɔ̀ hɛn si gbɛ̀nɛ̀ nɔ̀rɛ̀ nɔ̀ tɔ̀gɔ̀nɛ̀. Gaani wé nɔ́ gbè yá “kɔ̀lɔ nɔ̀ tɔ́” kple “rɛ̀nɛ̀ nɔ̀ si kpɔ̀”. Wé do kplɔ gbɛ̀nɛ̀ kplɔ xwɛ̀nu, wé do kpɔn gblɔ nu nɔ̀ kpɔn tɔ̃, kplɔ xwɛ̀nu kplɔ hɛn si Bariba.

Gaani tɔ̃ ló xwɛ̀nu kplɔ tɔ̃ kpɔnkpɔn si gbɛ̀nɛ̀. Wé kpɔn kpɔn nɔ̀ tɔ́ kplɔ hɛn, wé kpɔn nu nɔ̀ tɔ̃, wé kpɔn kpɔn kplɔ hɛn si nu gbɛ̀nɛ̀. Tɔ̃ nɔ̀rɛ̀, gblɔ nu kplɔ hɛn wé do kpɔn kpɔn tɔ̃, wé do nɔ̀ hɛn si gbɛ̀nɛ̀ kplɔ xwɛ̀nu, wé do kpɔn nu kplɔ hɛn si rɛ̀nɛ̀.

Wé kpɔn tɔ̃ nu hɛn tɔ̃ kpɔnkpɔn, wé kpɔn xwɛ̀nu kplɔ gbe nu. Kɔ̀ nu fɛ̀, wé kpɔn tɔ̃ kpɔnkpɔn si gblɔ nu kplɔ hɛn. Wé kpɔn kpɔn tɔ̃, wé do kpɔn xwɛ̀nu kplɔ gbe nu kple núwɔnu hɛn.

Gaani kpɔn hɛn kplɔ nu hɛn si Bariba tɔ̀gɔ̀nɛ̀. Wé do kpɔnkpɔn nɔ̀ kplɔ hɛn si gbɛ̀nɛ̀, wé kpɔn xwɛ̀nu, wé kpɔn nu kplɔ hɛn, wé do kpɔn kpɔn nɔ̀ si nu hɛn si tɔ̃ kpɔn.',
                'idRegion' => 4, 'idLangue' => 3, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'Conte Yoruba : Ajantè et le tam-tam magique',
                'texte' =>'Adjantè jẹ́ ìtàn àtọ́ka Yoruba tó kún fún ọgbọ́n àti ìtàn ìmọ̀lára. Adjantè jẹ́ ẹni tí ó ní ọgbọ́n àti ẹ̀tan, ẹni tí ó máa ń yanjú iṣòro nípa ọgbọ́n, ṣùgbọ́n pẹ̀lú ẹ̀rin àti ìtàn ìtàn. Àwọn tám-tám jẹ́ ohun èlò ìbánisọ̀rọ̀ àti ìbáṣepọ̀ pẹ̀lú àwọn ènìyàn àti àwọn ẹ̀mí.

Ní ìtàn náà, Adjantè wà nínú abúlé kan. Ó jẹ́ olókìkí fún ọgbọ́n rẹ̀ àti bí ó ṣe máa ń ṣe ìrìnàjò àtọ́ka. Ọjọ́ kan, olórí abúlé fi àṣẹ fún Adjantè láti dá àwọn tám-tám mímọ́ ṣọ́. Tám-tám náà jẹ́ ohun èlò tí ó ṣe pàtàkì fún ayẹyẹ àti ìbáṣepọ̀ pẹ̀lú àwọn ìran àtijọ́.

Adjantè lo ọgbọ́n rẹ̀, kì í ṣe agbára ara rẹ̀, láti dá tám-tám náà bo. Ó ṣe é pẹ̀lú ọgbọ́n àti ẹ̀tan, ó sì tún fa ẹ̀rín bá àwọn olùgbé abúlé. Ní ipari, Adjantè fi hàn pé ọgbọ́n àti ọgbọ́n àtọ́ka lè wúlò ju agbára lọ.

Ìtàn náà fi ẹ̀kọ́ hàn pé ọgbọ́n àti ìṣètò jẹ́ ohun pàtàkì, àti pé tám-tám ṣe aṣoju ìbáṣepọ̀, ìṣọkan àti ìbáṣepọ̀ pẹ̀lú ayé àti àwọn ẹ̀mí. Àwọn ìtàn bí Adjantè jẹ́ kí àwọn ọmọ ilé mọ̀ ọgbọ́n, ìmọ̀lára àti ìbáṣepọ̀ pẹ̀lú àwọn aládùúgbò wọn.',
                'idRegion' => 1, 'idLangue' => 2, 'idTypeContenu' => 2,
            ],
            [
                'titre' => 'Les rituels du Nouvel An au Bénin',
                'texte' => 'Au Bénin, le Nouvel An est célébré avec une combinaison unique de traditions ancestrales, de rituels vodoun et de pratiques modernes. Les festivités ne se limitent pas aux feux d’artifice ou aux repas festifs ; elles englobent des actes de purification, de protection et de bénédiction pour accueillir l’année à venir.

Les rituels commencent souvent avant le 31 décembre par le nettoyage des maisons, symbolisant la purification de l’espace et l’éloignement des énergies négatives. Les familles se rendent également dans les sanctuaires vodoun pour présenter des offrandes aux esprits et aux ancêtres. Ces offrandes incluent généralement du vin de palme, des fruits, du poisson ou du poulet, selon la divinité honorée. Les prêtres et prêtresses dirigent ces cérémonies, chantant des invocations et exécutant des danses rituelles pour assurer la protection et la prospérité de la communauté.

Le jour du Nouvel An, certaines communautés organisent des processions et des danses sacrées, comme le Zangbéto ou d’autres danses locales, pour chasser les mauvais esprits et attirer la bonne fortune. La musique joue un rôle central : les tambours, les balafons et les cloches rythment les danses et permettent aux participants de se connecter aux forces invisibles.

Les rituels incluent aussi des pratiques de prédiction et de divination. Les voyants consultent les signes, les coquillages ou les cartes traditionnelles pour annoncer ce que l’année à venir réserve. Ces prédictions guident les choix de la communauté, de la famille et parfois même des individus, afin de rester en harmonie avec les forces spirituelles.

Enfin, les rituels du Nouvel An au Bénin renforcent le lien social et spirituel. Ils permettent de remercier les ancêtres, de purifier la maison et de préparer la communauté à affronter l’avenir avec sérénité et courage. Chaque geste, chaque offrande et chaque danse a une signification profonde, reliant le passé au présent et créant un pont entre les vivants et le monde invisible.',
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Histoire du roi Guézo',
                'texte' => 'L’histoire du roi Guézo, grand réformateur du royaume du Danxomè

Le roi Guézo est l’une des figures les plus marquantes de l’histoire du royaume du Danxomè. Son règne, qui s’étend approximativement de 1818 à 1858, constitue une période charnière marquée par de profondes réformes politiques, militaires, économiques et sociales. Guézo est surtout connu comme un souverain visionnaire qui a su renforcer l’autorité royale tout en adaptant le royaume aux mutations de son époque.

Guézo, de son nom de naissance Gakpe, est le fils du roi Adandozan. Cependant, l’accession au trône ne se fait pas sans conflit. Après la destitution controversée de son père, Guézo prend le pouvoir avec le soutien déterminant de certains dignitaires du royaume et de l’armée. Cette prise de pouvoir marque le début d’un règne fondé sur la légitimation par l’efficacité, la discipline et la restauration de l’ordre traditionnel.

Dès son accession au trône, Guézo s’attelle à la réorganisation de l’État. Il renforce l’administration royale, restructure les charges politiques et exige une loyauté stricte envers la couronne. Il affirme clairement l’autorité du roi sur les chefs locaux, limitant leur autonomie afin de centraliser le pouvoir. Cette centralisation permet au Danxomè de gagner en stabilité interne et en cohésion politique.

Sur le plan militaire, le roi Guézo est un stratège redoutable. Il modernise l’armée du Danxomè, tant dans son organisation que dans son équipement. Il renforce notamment les célèbres troupes féminines, appelées communément les Amazones du Danxomè, qu’il transforme en une force militaire disciplinée, redoutée et respectée. Sous son règne, l’armée devient l’un des piliers majeurs de la puissance du royaume.

L’un des aspects les plus significatifs du règne de Guézo concerne l’économie. À une période où la traite négrière atlantique connaît un déclin progressif sous la pression des puissances européennes, Guézo comprend la nécessité d’une transition économique. Sans renoncer immédiatement à certaines pratiques anciennes, il encourage activement le développement de cultures agricoles commerciales, notamment celle du palmier à huile. Cette orientation vers l’agriculture d’exportation permet au royaume de maintenir des relations commerciales avec l’Europe tout en assurant une relative autonomie économique.

Sur le plan religieux et culturel, Guézo demeure profondément attaché aux traditions vodoun du Danxomè. Il protège les cultes ancestraux, renforce les cérémonies royales et accorde une place centrale aux rites, aux oracles et aux pratiques spirituelles dans la gestion du royaume. Pour lui, le pouvoir royal est indissociable du sacré, et le roi gouverne autant par l’autorité politique que par la légitimité spirituelle.

Le roi Guézo se distingue également par sa vision diplomatique. Il entretient des relations complexes avec les Européens, alternant négociations, résistances et compromis selon les intérêts du royaume. Son objectif principal demeure la préservation de la souveraineté du Danxomè face aux pressions extérieures croissantes.

À sa mort en 1858, Guézo laisse derrière lui un royaume renforcé, organisé et respecté. Son héritage perdure dans la mémoire collective comme celui d’un roi réformateur, guerrier et stratège, qui a su conjuguer tradition et adaptation. Aujourd’hui encore, Guézo est considéré comme l’un des plus grands souverains du Danxomè, symbole d’autorité, de sagesse politique et de résistance historique.',
                'idRegion' => 1, 'idLangue' => 6, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'La danse Zangbéto',
                'texte' => 'La danse Zangbéto est une manifestation culturelle et spirituelle des peuples du sud du Bénin, notamment chez les Gouns et les Fon. Les Zangbétos sont des esprits de la nuit qui protègent les villages contre les malfaiteurs et les mauvais esprits. La danse Zangbéto combine donc spectacle visuel, rituel de protection et célébration communautaire.

Le Zangbéto se présente sous la forme d’une grande structure de paille ou de fibres végétales qui recouvre entièrement le danseur, le rendant méconnaissable. Lorsqu’il danse, le Zangbéto se déplace de façon rapide et imprévisible, accompagné par des tambours puissants et des chants rituels. Chaque mouvement symbolise la chasse aux esprits néfastes et le maintien de l’ordre dans le village.

La danse est souvent exécutée lors des fêtes, des cérémonies de Nouvel An, ou lors de situations nécessitant protection et purification. Les villageois la considèrent comme un moment sacré : le Zangbéto ne danse pas seulement pour divertir, il inspecte également le comportement des habitants, et selon la tradition, il peut punir symboliquement ceux qui ont commis des actes immoraux.

Les rythmes de la danse Zangbéto sont complexes et codifiés, chaque tambour et chaque pas transmettant un message précis. Le danseur, en devenant le Zangbéto, est considéré comme un intermédiaire entre le monde des vivants et les forces invisibles. La transe, la musique et la participation de la communauté créent une atmosphère unique, où spectacle et rituel se confondent pour assurer la protection et l’harmonie.

La danse Zangbéto illustre parfaitement l’art de mêler culture, spiritualité et éducation morale dans les sociétés béninoises. Elle perpétue des valeurs de justice, de respect et de solidarité, tout en offrant un moment spectaculaire qui fascine les générations de tous âges.',
                'idRegion' => 1, 'idLangue' => 6, 'idTypeContenu' => 6,
            ],
            [
                'titre' => 'Recette du Amiwô',
                'texte' => 'L’amiwô : un plat emblématique de la tradition culinaire béninoise

L’amiwô est l’un des plats les plus emblématiques de la gastronomie béninoise. Préparé à base de farine de maïs et de tomate écrasée qui lui donne sa coloration rouge caractéristique, il occupe une place centrale dans l’alimentation quotidienne comme dans les grandes cérémonies. Au-delà de son aspect nutritif, l’amiwô est un symbole de partage, d’identité et de continuité culturelle au Bénin.

À l’origine, l’amiwô tire ses racines des communautés du sud du Bénin, notamment chez les peuples fon, goun et apparentés. Le maïs, ingrédient principal, est cultivé depuis plusieurs siècles et constitue l’une des bases alimentaires les plus accessibles et les plus durables de la région. La transformation du maïs en farine, puis en pâte, témoigne d’un savoir-faire ancien transmis de génération en génération, principalement par les femmes.

La particularité de l’amiwô réside dans sa coloration rouge, obtenue grâce à la tomate écrasée. Dans les pratiques traditionnelles, les tomates fraîches sont pilées au mortier, puis filtrées afin d’en extraire un jus épais. Ce jus est ensuite intégré à la préparation du plat, donnant à l’amiwô sa teinte rouge distinctive, qui le différencie des autres pâtes de maïs plus claires comme l’akassa ou le owo. Cette couleur est souvent associée à la fête, à l’abondance et à la célébration.

La préparation de l’amiwô est un processus méthodique qui requiert patience et maîtrise. La farine de maïs est d’abord délayée dans de l’eau, puis mélangée à la tomate écrasée. Le mélange est ensuite cuit à feu doux tout en étant remué continuellement à l’aide d’une spatule en bois. Ce mouvement constant est essentiel pour éviter la formation de grumeaux et pour obtenir une pâte lisse, homogène et ferme. La cuisson demande de la rigueur, car la texture finale est déterminante pour la qualité du plat.

Sur le plan gustatif, l’amiwô se distingue par sa saveur légèrement acidulée, due à la tomate, et par sa consistance dense et rassasiante. Il est généralement accompagné de sauces riches et variées, telles que la sauce tomate au poisson frit, la sauce arachide, la sauce gombo ou encore des sauces à base de viande. Ces accompagnements renforcent la valeur nutritionnelle du plat et illustrent la diversité culinaire béninoise.

L’amiwô occupe également une place importante dans les cérémonies traditionnelles, les fêtes familiales et les rassemblements communautaires. Il est souvent servi lors des mariages, des funérailles, des fêtes religieuses et des événements coutumiers. Dans ces contextes, sa préparation devient un acte collectif, renforçant les liens sociaux et symbolisant la solidarité.

Aujourd’hui, bien que les habitudes alimentaires évoluent avec la modernité, l’amiwô demeure un pilier de la cuisine béninoise. Il continue d’être préparé aussi bien dans les foyers que lors des grandes occasions, perpétuant ainsi une tradition culinaire profondément enracinée dans l’histoire et l’identité du Bénin.

En définitive, l’amiwô n’est pas seulement un repas. Il incarne une mémoire culturelle, un patrimoine gastronomique et une expression vivante du savoir-faire béninois transmis à travers les générations.',
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 3,
            ],
            [
                'titre' => 'Tassi Hangbè, nyɔnu tɔn tón lẹ́ Danxomɛ́',
                'texte' => 'Tassi Hangbè nyɛ nyɔnu tɔn gán-gán deka Danxomɛ́. E jẹ́ vi Axɔ́sú Wegbaja ƒe kpɔ́n, bo wá nyɔnu Kpɛ́n Agaja kpɔ́n. Le xɔ́sú Danxomɛ́ me, nyɔnu ma ɔ́ bọ wá xɔ́sú le ame tɔ́n la, gbo nɔ́ gbe ɔ́, na e be e jẹ́ xɔ́sú blɛ́blɛ́, bɔ́ e sɛ̀ hɔn yí nyɔnu tɔn xlɛ̀.

Le sọdọ́ xɔ́sú Akaba kú, Danxomɛ́ ku nyí tɔn lɛ, bo nyɔnu Tassi Hangbè wá sɔ̀ xɔ́sú tɔn na gbe kɔ́kɔ́ɖé, sún gbɛ̀ nɔ́ gba na Agaja. Le kɔ́kɔ́ɖé tɔn yì, e dɔ́ dɔ́ nu, e tɔn ɖoɖo kɔ́ xɔ́sú, e gbé agbasa sún ame tɔn lɛ hɔn tɔn. E nɔ́ nyɔnu gán, e ɖo nyí xɔ́sú kún e na Danxomɛ́ nɔ́ kùklùkù.

Tassi Hangbè tɔn kún nɔ́ ablẹ̀ gba lɛ́ nɔ́. Le e tɔn wíwá me, e gbé aja lɛ gbɛ̀, e yọ́ gɔ́nnu lɛ tɔn, e tɔn ɖa mɛ́nu wɛ nɔ́ xɔ́sú lɛ gbɔ́n. E jẹ́ nyɔnu si tɔn dɔ́ xɔ́sú tɔn gbe, bo jɛ́ tɔn xɔ́sú tɔ́n nɔ́ mɛ́ɖe.

Nyɔnu Hangbè tɔn ɖokpo nɔ́ kún bɔ́ Axɔ́sú Danxomɛ́ nɔ́. E yí kɔ́kɔ́ ɖa azɔ́wɛnnu tɔn, e tɔn sùn sún tɔn wɔ́n mɛ́, e tɔn kpɔn wíwá tɔn lɛ nɔ́. E nɔ́ hɛnnu, e nɔ́ gɔ́nnu, e nɔ́ xɔ́sú tɔn hɛ̀n.

Gbe kɔ́kɔ́ɖé, e tɔn kpa Agaja gɔ́n mɛ́, e bɔ́ wá ɖe xɔ́sú tɔn dó. Kún e gbo gbà, nyɔnu Tassi Hangbè kpɔn be nyɔnu xɔ́sú sí nɔ́ Danxomɛ́ tɔn lɛ, nɔ́ nùkún, nɔ́ kpa, nɔ́ gɔ́n tɔn.

Ɛ̀ɖé, le Danxomɛ́ tɔn xá, Tassi Hangbè nɔ́ nyɔnu gán, nyɔnu sɛ̀dó, si tɔn fɔ́n ɖe nyɔnu tɔn le xɔ́sú me. E jẹ́ adan bɔ̀ Danxomɛ́, bo e tɔn gbe yí gbe yí nɔ́ xá.',
                'idRegion' => 1, 'idLangue' => 1, 'idTypeContenu' => 1,
            ],
            [
                'titre' => 'Forêt de Kpassè : mythes et protections',
                'texte' => 'La forêt de Kpassè occupe une place essentielle dans le patrimoine culturel et spirituel du Bénin. Considérée comme une forêt sacrée, elle ne se limite pas à un simple espace naturel, mais représente un lieu profondément enraciné dans les croyances traditionnelles des communautés locales. À travers les mythes qui l’entourent et les règles strictes qui assurent sa protection, la forêt de Kpassè illustre le lien étroit entre l’homme, la nature et le sacré.

Selon la tradition orale, la forêt de Kpassè est habitée par des forces invisibles et des esprits protecteurs qui veillent sur les populations environnantes. Certains récits rapportent que ces entités spirituelles seraient les gardiennes des lieux et qu’elles accorderaient prospérité, santé et paix aux communautés respectueuses des interdits coutumiers. À l’inverse, toute atteinte à l’équilibre de la forêt serait sanctionnée par des malheurs, interprétés comme des avertissements spirituels.

Les mythes liés à la forêt de Kpassè jouent un rôle fondamental dans sa préservation. Ils fonctionnent comme des mécanismes de régulation sociale, dissuadant l’exploitation abusive des ressources naturelles. La coupe anarchique du bois, la chasse non autorisée ou l’accès à certaines zones sacrées sont strictement interdits. Ces règles, édictées par les chefs traditionnels et les autorités religieuses, sont respectées non seulement par crainte des sanctions mystiques, mais aussi par attachement à l’héritage ancestral.

La forêt de Kpassè est également un lieu de pratiques rituelles. Elle accueille des cérémonies vodoun, des rites de purification et des prières collectives visant à maintenir l’harmonie entre les hommes, les ancêtres et les divinités. Dans ces moments, la forêt devient un espace sacré de communication avec le monde invisible, un sanctuaire où se renforce l’identité culturelle des communautés.

Sur le plan écologique, la protection traditionnelle de la forêt de Kpassè a favorisé la conservation d’une biodiversité remarquable. Grâce aux interdits culturels, certaines espèces végétales et animales rares ont pu être préservées, bien avant l’apparition des politiques modernes de protection de l’environnement. Ce modèle de conservation basé sur le sacré démontre l’efficacité des savoirs ancestraux dans la gestion durable des ressources naturelles.

Aujourd’hui, malgré les défis liés à la modernisation et à la pression foncière, la forêt de Kpassè demeure un symbole vivant de résistance culturelle et écologique. Sa préservation repose à la fois sur le respect des traditions et sur la sensibilisation des générations futures. Elle rappelle que les mythes et les croyances, loin d’être de simples récits, constituent des piliers essentiels de la protection du patrimoine naturel et culturel du Bénin.',
                'idRegion' => 4, 'idLangue' => 6, 'idTypeContenu' => 4,
            ],
            [
                'titre' => 'Yôgbo le glouton',
                'texte' => 'Il était une fois, dans un village paisible, un homme appelé Yôgbo. Yôgbo était connu de tous, non pas pour sa bravoure ou sa sagesse, mais pour sa gloutonnerie excessive. Il aimait manger plus que tout au monde. Peu importait l’heure, la situation ou les autres, Yôgbo pensait toujours à son ventre.

Au marché, lorsqu’on préparait un repas collectif, Yôgbo arrivait le premier et repartait le dernier. Chez ses voisins, il trouvait toujours une excuse pour se faire inviter. On disait souvent :
« Quand Yôgbo arrive, la marmite tremble. »

Un jour, le chef du village annonça une grande fête. Chacun devait apporter un plat pour partager avec tous. Les femmes cuisinèrent avec soin, les hommes préparèrent la cour, et les enfants attendaient avec impatience. Yôgbo, lui, ne pensa qu’à une chose : comment manger plus que les autres.

Avant le début de la fête, Yôgbo se faufila près des marmites. Il goûta un plat, puis un autre, puis encore un autre. Il mangea tant qu’il ne laissa presque rien. Quand les villageois arrivèrent pour partager le repas, ils découvrirent des marmites presque vides.

Le chef, très en colère, demanda :
« Qui a mangé la nourriture destinée à tous ? »

Personne n’osa parler, mais le ventre de Yôgbo, trop plein, se mit à gargouiller bruyamment. Honteux, Yôgbo fut démasqué. Le chef décida alors de lui donner une leçon.

Le lendemain, on annonça un autre repas collectif. Cette fois-ci, Yôgbo fut installé devant une grande marmite, tout seul. On l’encouragea à manger autant qu’il voulait. Aveuglé par la gourmandise, Yôgbo mangea sans s’arrêter. Soudain, il eut un terrible mal de ventre et tomba malade pendant plusieurs jours.

Quand il guérit, Yôgbo comprit enfin son erreur. Il demanda pardon au village et promit de changer. Depuis ce jour, il mange avec modération et respecte le partage.

Morale :

La gloutonnerie conduit à la honte et à la punition. Le partage et la mesure sont des valeurs essentielles de la vie en société.',
                'idRegion' => 2, 'idLangue' => 6, 'idTypeContenu' => 2,
            ],
            [
                'titre' => 'Recette du Gboman ',
                'texte' =>'Le Gboman est une sauce traditionnelle béninoise à base de feuilles de gboman (amarante) et de légumes frais. Très populaire dans les familles béninoises, cette sauce accompagne généralement le riz, le foutou, le couscous de maïs ou l’akassa. Elle est reconnue pour sa couleur verte éclatante, sa richesse en vitamines et sa saveur unique qui séduit petits et grands.

Ingrédients principaux

Feuilles de gboman fraîches et bien lavées.

Tomates mûres écrasées ou en purée.

Oignons et gousses d’ail.

Piment frais (selon le goût).

Huile de palme rouge pour la couleur et le goût.

Sel et cubes bouillon ou épices locales selon préférence.

Eventuellement, légumes complémentaires (carottes, aubergines locales).

Préparation

Préparer les feuilles : Laver soigneusement les feuilles de gboman pour enlever toute impureté et hacher finement.

Faire la base de la sauce : Chauffer l’huile de palme dans une marmite et y faire revenir les oignons, l’ail et le piment jusqu’à ce qu’ils soient parfumés. Ajouter les tomates écrasées et cuire jusqu’à obtenir une purée homogène.

Cuire les feuilles : Ajouter les feuilles de gboman hachées dans la sauce et remuer régulièrement. Laisser mijoter jusqu’à ce que les feuilles deviennent tendres et que la sauce prenne une belle couleur verte.

Assaisonner : Ajouter le sel, les cubes bouillon et autres épices locales. Goûter et ajuster l’assaisonnement selon les préférences.

Finaliser : Laisser la sauce mijoter encore quelques minutes pour que toutes les saveurs se mélangent parfaitement.

Service

Le Gboman se sert chaud et accompagne souvent le riz blanc, le maïs moulu, le foutou ou l’akassa. On peut ajouter du poisson fumé, du poulet ou de la viande selon les habitudes et la disponibilité, mais la base reste toujours les feuilles de gboman et les légumes.

Importance culturelle

La sauce Gboman est bien plus qu’un simple plat : elle est symbole de nutrition, de tradition et de partage familial. Elle reflète l’ingéniosité culinaire béninoise qui transforme des légumes simples en un repas savoureux et nutritif. Préparer le Gboman dans un village ou une famille béninoise est un acte quotidien, mais aussi un moment de transmission des savoirs culinaires d’une génération à l’autre.',
                'idRegion' => 3, 'idLangue' => 6, 'idTypeContenu' => 3,
            ],
            [
                'titre' => 'Àjọyọ̀ Kouvitô (Le cérémonial des revenants)',
                'texte' => 'Ní ilẹ̀ Yorùbá, Kouvitô jẹ́ àwọn ẹ̀mí tí ó ti kú tí ń padà wá sí ayé àwọn olùgbé. Wọ́n jẹ́ àpẹẹrẹ ti ìbáṣepọ̀ láàárín àwọn aláyè àti àwọn tí ó ti lọ. Láti tọ́jú ìbáṣepọ̀ yìí, àwọn ènìyàn ṣe àjọyọ̀ Kouvitô, ìṣẹ̀lẹ̀ pẹ̀lú àwọn ìlànà àti ẹ̀sìn tó kún fún ìbáṣepọ̀ pẹ̀lú àwọn ẹ̀mí.

Ìlànà àjọyọ̀ Kouvitô

Àjọyọ̀ yìí máa bẹ̀rẹ̀ nílé àwọn olùṣàkóso ẹ̀sìn tàbí nílé-ọba, níbi tí àwọn alákóso ẹ̀sìn yóò ti ṣe àdúrà àti ìbẹ̀wò fún àwọn Kouvitô. Àwọn olùṣàkóso yóò tọ́jú àṣà àtijọ́, wọ́n sì máa fi òògùn, òru àti orin àṣà hàn láti kéde pé àwọn ẹ̀mí wà ní àkóso.

Àwọn ará ìlú máa kópa pẹ̀lú àjọyọ̀ orílé, tí wọ́n máa fi ọ̀pá, òrìṣà àti àwọn ohun ìbánújẹ́ hàn. Àwọn kouvitô yóò fi àpẹẹrẹ ìbáṣepọ̀ àti ìbáwí hàn: kí wọ́n mọ̀ pé àwọn aláyè ń bọ́ sílẹ̀ pẹ̀lú ìbànújẹ́ àti ìtẹ́lọ́run.

Ìdí àti àṣẹ̀ṣe

Ìpinnu àjọyọ̀ Kouvitô ni láti mú àlàáfíà wá sí ìlú àti ẹbí. Wọ́n gbà pé bí a ṣe bọ́rẹ̀ sí àwọn ẹ̀mí, wọn máa daabobo ìlú, yóò sì mú ìbáṣepọ̀ láàárín àwọn aláyè àti àwọn ẹ̀mí pọ̀ sí i. Ní gbogbo àjọyọ̀ náà, àwọn aláyè kọ́ ẹ̀kọ́ láti bọ́rẹ̀, kí wọ́n sì rántí pé ìbáṣepọ̀ àti ìtìlẹ́yìn fún ẹbí àti àwọn ẹ̀mí jẹ́ ohun pàtàkì.

Àtúnṣe àṣà

Àjọyọ̀ yìí tun jẹ́ àkókò láti tún àwọn àṣà àti ìmọ̀ ìbílẹ̀ ṣe. Awọn ìtàn, orin, àti ìjùmọ̀lọ́mọ̀ hàn fún àwọn ọmọde kí wọ́n lè kọ́ ẹ̀kọ́ nípa ìbáṣepọ̀ pẹ̀lú àwọn ẹ̀mí, ìbáwí àti ìbànújẹ́. Ìmọ̀ yìí máa ran wọn lọwọ láti mọ iye ìbáṣepọ̀ àtijọ́ àti ìdájọ́ ẹbí.

Àkótán

Àjọyọ̀ Kouvitô jẹ́ àfihàn pé àwọn Yorùbá gbà pé àyè àti ẹ̀mí kọ́ lópin. Nípa àwọn àṣà yìí, wọn ń dáàbò bo ìbáṣepọ̀ láàárín aláyè àti àwọn Kouvitô, wọn ń fi ọlá fún àwọn tí ó ti lọ, àti pé wọn ń fi ìtẹ́lọ́run hàn pé àjọyọ̀ àti àṣà jẹ́ ohun pàtàkì nínú ìgbé ayé.',
                'idRegion' => 1, 'idLangue' => 2, 'idTypeContenu' => 4,
            ],
        ];

        foreach ($contenus as $c) {

            // Un auteur au hasard
            $auteur = fake()->randomElement($auteurs);

            // On décide si le contenu est validé ou en cours
            $estValide = fake()->boolean(60); // 60 % seront validés

            Contenu::create([
                'titre' => $c['titre'],
                'texte' => $c['texte'],
                'statut' => $estValide ? 'validé' : 'en cours',
                'dateCreation' => now(),
                'dateValidation' => $estValide ? now() : null,
                'idTypeContenu' => $c['idTypeContenu'],
                'idAuteur' => $auteur,
                'idParent' => null,
                'idRegion' => $c['idRegion'],
                'idLangue' => $c['idLangue'],
                'idModerateur' => $estValide ? fake()->randomElement($moderateurs) : null
            ]);
        }
    }
}
