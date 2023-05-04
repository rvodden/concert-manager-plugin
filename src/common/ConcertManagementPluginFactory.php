<?php
namespace uk\org\brentso\concertmanagement\common;

use uk\org\brentso\concertmanagement\admin\{AdminMenu, SettingsPage};
use uk\org\brentso\concertmanagement\ConcertManagementPublic;
use uk\org\brentso\concertmanagement\common\posts;
use uk\org\brentso\concertmanagement\common\taxonomy;

/**
 *
 * @author voddenr
 */
class ConcertManagementPluginFactory implements PluginFactoryInterface
{
    public static function createPlugin()
    {
        $plugin_name = 'concert-manager';
        $plugin_version = '0.0.1';
        
        $loader = new Loader();
        $concertManagementPublic = new ConcertManagementPublic($plugin_name, $plugin_version);
        $settingsPage = new SettingsPage($plugin_name, $plugin_version);
        $i18n = new I18n();

        /*
         * ADMIN MENU
         */

        $adminMenu = new AdminMenu(
            $loader,
            "Concert Manager",
            "Concert Manager",
            "read", // TODO: fix this :-)
            "concert_manager",
            "",
            "dashicons-tickets-alt",
            10
        );

        /*
         * SEASON POST TYPE
         */
        
        $seasonPostType = (new posts\PostType($loader))
            ->setLabels((new posts\PostLabels())->setSingularName("Season"))
            ->setAdminMenu($adminMenu)
            ->addCustomField((new fields\CustomTextField($loader))
                ->setName("season-number")
                ->setTitle("Season Number")
                ->setDescription("The number of the season (e.g. this is Brent Symphony Orchetra's 111th season)"))
            ->addCustomField( (new fields\CustomTextField($loader))
                ->setName("season-start-year")
                ->setTitle("Start Year")
                ->setDescription("The year in which the season starts."));
        
        /*
         * ROLE TAXONOMY
         */
        
        $roleTaxonoy = new taxonomy\Taxonomy(
            $loader,
            new taxonomy\TaxonomyLabels("Role")
        );
        $roleTaxonoy->addTerm('Conductor');
        $roleTaxonoy->addTerm('Leader');
        $roleTaxonoy->addTerm('Composer');

        /*
         * PERSON POST TYPE
         */
        
        $personPostType = (new posts\PostType($loader))
            ->setLabels( (new posts\PostLabels())->setSingularName("Person")->setPluralName("People") )
            ->setAdminMenu($adminMenu);
        $roleTaxonoy->registerPostType($personPostType->getSlug());
        
        /*
         * PIECE POST TYPE
         */

        $piecePostType = (new posts\PostType($loader)) 
            ->setLabels((new posts\PostLabels())->setSingularName("Piece"))
            ->setAdminMenu($adminMenu)
            ->removeSupport('editor')
            ->addCustomField((new fields\CustomPostTypeByTermField($loader))
                ->setName("piece-composer")
                ->setTitle("Composer")
                ->setDescription("The person who composed this piece.")
                ->setPostType($personPostType)
                ->setTaxonomy($roleTaxonoy)
                ->setDisplayInAdminTables(true)
                ->setTerm('Composer'))
            ->addCustomField((new fields\CustomTextField($loader))
                ->setName("piece-orchestration")
                ->setTitle("Orchestration")
                ->setDescription("The players needed to perform this piece."));


        /*
         * CONCERT POST TYPE
         */

        $concertPostType = (new posts\PostType($loader)) 
            ->setLabels((new posts\PostLabels())->setSingularName("Concert"))
            ->setAdminMenu($adminMenu)
            ->addCustomField((new fields\CustomPostTypeByTermField($loader))
                ->setName("concert-conductor")
                ->setTitle("Conductor")
                ->setDescription("The person who conducted this concert.")
                ->setPostType($personPostType)
                ->setTaxonomy($roleTaxonoy)
                ->setTerm('Conductor'))
            ->addCustomField((new fields\CustomPostTypeByTermField($loader))
                ->setName("concert-leader")
                ->setTitle("Leader")
                ->setDescription("The person who lead the orchestra for this concert.")
                ->setPostType($personPostType)
                ->setTaxonomy($roleTaxonoy)
                ->setTerm('Leader'))
            ->addCustomField((new fields\CustomPostTypeField($loader))
                ->setName("concert-season")
                ->setTitle("Season")
                ->setDescription("The season during which this concert took place.")
                ->setPostType( $seasonPostType ) )
            ->addCustomField((new fields\CustomDateField($loader))
                ->setName("concert-date")
                ->setTitle("Date")
                ->setDescription("The date on which the concert took place.")
                ->setDisplayInAdminTables(true))
            ->addCustomField((new fields\CustomPostTypeTableField($loader))
                ->setName("concert-pieces")
                ->setTitle("Pieces")
                ->setDescription("The pieces which are being performed during this concert.")
                ->setPostType($piecePostType));
        
        $postTypes = [
            $seasonPostType,
            $concertPostType,
            $piecePostType,
            $personPostType
        ];

        $concertManagementPlugin = new ConcertManagementPlugin(
            $loader,
            $concertManagementPublic,
            $settingsPage,
            $i18n,
            $postTypes,
            [],
        );
        
        return $concertManagementPlugin;
    }
}
