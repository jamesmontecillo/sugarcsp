<?PHP

// manifest file for information regarding application of new code
$manifest = array(
    // only install on the following regex sugar versions (if empty, no check)
    'acceptable_sugar_versions' => array(),

    // name of new code
    'name' => 'API for Creating Portal users',

    // description of new code
    'description' => '6.1.3 -  Create a new entrypoint for an API to create portal users and link to account',

    // author of new code
    'author' => 'ATCORE Systems',

    // date published
    'published_date' => '2011/03/2',

    // version of code
    'version' => '6.1.3',

    // type of code (valid choices are: full, langpack, module, patch, theme )
    'type' => 'module',

    // icon for displaying in UI (path to graphic contained within zip package)
    'icon' => '',

     'is_uninstallable' => true,
);



$installdefs = array(
        'id'=> 'CustomCreatePortalUser',


        'copy' => array(
                                                array('from'=> '<basepath>/custom',
                                                          'to'=> 'custom',
                                                          ),


                                               
                                        ),


        'language'=> array(
                                        ),
        'administration'=> array(
                                          ),
        'beans'=> array(
                                          ),
        'relationships'=>array(
                                        ),
        'custom_fields'=>array(
                                        ),

);
?>

