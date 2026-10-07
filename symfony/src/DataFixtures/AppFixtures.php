<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Configuration;
use App\Entity\Health;
use App\Entity\HealthType;
use App\Entity\Horse;
use App\Entity\Like;
use App\Entity\Rate;
use App\Entity\RateCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Données de démonstration (développement uniquement).
 * Les chevaux, articles et commentaires sont fictifs ; les tarifs reprennent ceux du site actuel.
 * Le compte administrateur n'est pas créé ici : il le sera avec la sécurité (mot de passe haché).
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ---------- Configuration ----------
        foreach ([
            'rates_season' => '2025-2026',
            'background_color' => '#FAF6EE',
        ] as $name => $value) {
            $manager->persist((new Configuration())->setName($name)->setValue($value));
        }

        // ---------- Tarifs ----------
        $clubCategory = (new RateCategory())
            ->setName('Cavaliers du club')
            ->setNote(
                "Cours en forfaits trimestriels. Stages de perfectionnement pendant les vacances.\n"
                . "Famille nombreuse : -10 % sur le second forfait.\n"
                . "Tout cours ou stage non pris au jour et à l'heure prévus est facturé. "
                . "Jusqu'à deux absences par forfait peuvent être rattrapées pendant les vacances scolaires."
            )
            ->setPosition(1);
        $passageCategory = (new RateCategory())
            ->setName('Cavaliers de passage')
            ->setNote(
                "Tout cours ou stage non pris est facturé, mais peut être rattrapé pendant les vacances "
                . "scolaires de votre choix. Merci de prévenir au plus tôt en cas d'absence."
            )
            ->setPosition(2);
        $manager->persist($clubCategory);
        $manager->persist($passageCategory);

        $rates = [
            [$clubCategory, 'Licence FFE · enfant', '29.00', null],
            [$clubCategory, 'Licence FFE · adulte', '40.00', null],
            [$clubCategory, 'Adhésion', '48.00', null],
            [$clubCategory, 'Adhésion famille', '70.00', null],
            [$clubCategory, 'Cours', '19.00', 'Durée : 1h15'],
            [$clubCategory, 'Cours baby (dès 2 ans)', '17.00', 'Durée : 1h'],
            [$clubCategory, 'Carte baby', '160.00', '10 séances'],
            [$clubCategory, 'Stage débutants', '21.00', 'Pendant les vacances · durée : 1h30'],
            [$clubCategory, 'Stage confirmés', '37.00', 'Pendant les vacances · durée : 3h'],
            [$clubCategory, 'Forfait 3 stages', '106.00', 'Pendant les vacances'],
            [$passageCategory, 'Séance découverte', '25.00', 'Dès 3 ans · durée : 1h30'],
            [$passageCategory, 'Stage Galop 2 et plus', '44.00', "Idéal à partir du Galop d'Or · durée : 3h"],
        ];
        foreach ($rates as $position => [$category, $name, $price, $description]) {
            $manager->persist(
                (new Rate())
                    ->setCategory($category)
                    ->setName($name)
                    ->setPrice($price)
                    ->setDescription($description)
                    ->setPosition($position + 1)
            );
        }

        // ---------- Cavalerie (chevaux fictifs) ----------
        $horses = [];
        foreach ([
            ['Caramel', 'Shetland', 'Alezan', 'Hongre', '2012-04-15', '1m05', 'Actif'],
            ['Vanille', 'Welsh', 'Gris', 'Jument', '2015-05-02', '1m25', 'Actif'],
            ['Orage', 'Connemara', 'Bai', 'Hongre', '2010-03-21', '1m40', 'Actif'],
            ['Praline', 'Shetland', 'Noir', 'Jument', '2018-06-10', '1m00', 'Actif'],
            ['Tonnerre', 'Poney de selle', 'Bai brun', 'Hongre', '2009-02-28', '1m35', 'Actif'],
            ['Étoile', 'Welsh', 'Palomino', 'Jument', '2005-07-19', '1m20', 'Retraité'],
        ] as [$name, $breed, $coat, $gender, $birthdate, $size, $status]) {
            $horse = (new Horse())
                ->setName($name)
                ->setBreed($breed)
                ->setCoat($coat)
                ->setGender($gender)
                ->setBirthdate(new \DateTime($birthdate))
                ->setSize($size)
                ->setStatus($status);
            $manager->persist($horse);
            $horses[] = $horse;
        }

        $healthTypes = [];
        foreach (['Vaccination', 'Vermifuge', 'Ferrure', 'Dentiste', 'Ostéopathe', 'Visite vétérinaire'] as $name) {
            $type = (new HealthType())->setName($name);
            $manager->persist($type);
            $healthTypes[$name] = $type;
        }

        // Dates relatives : la démo reste cohérente quel que soit le jour du chargement.
        foreach ([
            [$horses[0], 'Vaccination', '-3 months', '+9 months', 'Dr Martin', 'Rappel annuel grippe et tétanos.'],
            [$horses[0], 'Ferrure', '-1 month', '+1 month', 'Maréchal-ferrant', null],
            [$horses[1], 'Vermifuge', '-2 months', '+4 months', null, null],
            [$horses[2], 'Dentiste', '-6 months', '+6 months', 'Dr Martin', 'Raspage des dents.'],
            [$horses[5], 'Visite vétérinaire', '-20 days', null, 'Dr Martin', 'Contrôle de suivi, retraite confirmée.'],
        ] as [$horse, $typeName, $date, $reminder, $practitioner, $commentary]) {
            $manager->persist(
                (new Health())
                    ->setHorse($horse)
                    ->setHealthType($healthTypes[$typeName])
                    ->setDate(new \DateTime($date))
                    ->setReminderDate($reminder !== null ? new \DateTime($reminder) : null)
                    ->setPractitioner($practitioner)
                    ->setCommentary($commentary)
            );
        }

        // ---------- Blog ----------
        $categories = [];
        foreach (['Actualités', 'Stages', 'Concours'] as $name) {
            $category = (new Category())->setName($name);
            $manager->persist($category);
            $categories[$name] = $category;
        }

        $articles = [];
        foreach ([
            ['Actualités', '-12 days', 'Reprise des cours en septembre', "Les cours reprennent la semaine prochaine. Pensez à renouveler votre licence avant la première séance.\n\nLes inscriptions sont ouvertes au club."],
            ['Stages', '-5 days', 'Stages des vacances de la Toussaint', "Des stages de perfectionnement sont proposés pendant les vacances : balade en forêt, obstacle et travail à pied.\n\nPlaces limitées, inscription auprès du club."],
            ['Concours', '-2 days', 'Concours interne du club', "Un concours interne est organisé pour tous les niveaux. Venez encourager les cavaliers !"],
        ] as [$categoryName, $date, $title, $content]) {
            $article = (new Article())
                ->setCategory($categories[$categoryName])
                ->setDate(new \DateTime($date))
                ->setTitle($title)
                ->setContent($content);
            $manager->persist($article);
            $articles[] = $article;
        }

        foreach ([
            [$articles[0], 'Camille', 'Merci pour l\'info !', 'approuve', '-11 days'],
            [$articles[0], 'Julien', 'Très bien, on sera là.', 'approuve', '-10 days'],
            [$articles[0], 'Visiteur', 'Commentaire en attente de modération.', 'en_attente', '-1 day'],
            [$articles[1], 'Léa', 'Mon fils est ravi de s\'inscrire.', 'approuve', '-4 days'],
        ] as [$article, $pseudo, $content, $status, $date]) {
            $manager->persist(
                (new Comment())
                    ->setArticle($article)
                    ->setPseudo($pseudo)
                    ->setContent($content)
                    ->setStatus($status)
                    ->setDate(new \DateTime($date))
            );
        }

        foreach ([
            [$articles[0], 'session-demo-1'],
            [$articles[0], 'session-demo-2'],
            [$articles[0], 'session-demo-3'],
            [$articles[1], 'session-demo-1'],
        ] as [$article, $sessionId]) {
            $manager->persist(
                (new Like())
                    ->setArticle($article)
                    ->setSessionId($sessionId)
                    ->setDate(new \DateTime('-1 day'))
            );
        }

        $manager->flush();
    }
}