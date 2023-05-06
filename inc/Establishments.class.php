<?php
/**
 * Class Establishments
 */
class Establishments {
    use CustomersUtils;

    private string $cpt = 'stablishments';

    /**
     * EstablismentCPT constructor.
     */
    public function __construct( )
    {
        self::HooksAndFilters();
    }

    /**
     * Hooks And Filters
     */
    public function HooksAndFilters() : void
    {
        add_action('init', function(){
            $attr = array(
                'cpt' => $this->cpt,
                'singular' => 'Estabelecimento',
                'plural' => 'Estabelecimentos',
            );
            $args = array(
                'supports' => array( 'title', 'thumbnail' ),
                'menu_icon'           => 'dashicons-admin-multisite',
            );
            $labels = array(

            );
            self::CustomPostType($attr, $args, $labels);
        });
        add_action('init', array($this, 'RegisterTaxonomies'));
        add_action('fm_post_'.$this->cpt, array($this, 'MetaboxEstablismentCPT'));
        add_action('wp_enqueue_scripts', array($this, 'EstablismentEnqueue'));
        add_action('wp_head', array($this, 'EstablismentEnqueueStyles'));
        add_action( 'init', array( $this, 'EstablismentAjaxAddRewriteRules' ), 10 );
        add_action( 'parse_request', array( $this, 'EstablismentActionRequest' ), 10, 1 );
        add_action( 'save_post', array( $this, 'ActionSaveEstablismentCPT' ), 10, 3 );
        add_action('fm_term', array($this, 'TaxMetas'));
        add_action( 'wp_enqueue_scripts', function() {
            wp_enqueue_script( 'chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js', array(), true );
        });
        add_action('wp_footer', function(){
            wp_enqueue_script( 'establishments-chart-js', CustomerURL . '/assets/public/js/establishments-chart.js', array('chart-js'), true );
        });
        add_action('init', function(){
            self::IterateTerms('partner_add');
        });
    }


    public function EstablismentEnqueue( ) : void
    {
        global $post;

        $ajax_slug = 'Establisment';
        $vars = [
            'url'           => site_url('stablishment-ajax'),
            'nounce'         => wp_create_nonce( $ajax_slug . "_nounce" ),
            'action'         => 'EstablismentActionRequest',
            'Establisment_ajax'   => $ajax_slug,
        ];

        if(isset($post) && $this->cpt === $post->post_type || 'customers' === $post->post_type){
            wp_enqueue_script( 'stablishments-cpt-richtexteditor', CustomerURL . '/assets/richtexteditor/rte.js', array(), false, true );
            wp_enqueue_script( 'stablishments-cpt-richtexteditor-plugins', CustomerURL . '/assets/richtexteditor/plugins/all_plugins.js', array(), false, true );
            wp_enqueue_script( 'stablishments-cpt-scripts', CustomerURL . '/assets/public/js/establishments.js', array(), false, true );
            wp_localize_script('stablishments-cpt-scripts', $ajax_slug.'_js', $vars);
        }

    }

    /**
     * Establisment Enqueue Styles
     */
    public function EstablismentEnqueueStyles() : void
    {
        global $post;
        if(isset($post) && $this->cpt === $post->post_type || 'customers' === $post->post_type) {
            wp_enqueue_style('stablishments-rte-css', CustomerURL . '/assets/richtexteditor/rte_theme_default.css');
            wp_enqueue_style('stablishments-cpt-css', CustomerURL . '/assets/public/css/style.css');
        }
    }

    /**
     * Add Metaboxes and field to Establishments custom post type
     *
     * @throws FM_Developer_Exception
     */
    public function MetaboxEstablismentCPT () : void
    {
        $fmUser = new Fieldmanager_Group(array(
            'name' => 'estab_fields',
            'children' => array(
                'name' => new Fieldmanager_TextField('Título'),
                'description' => new Fieldmanager_RichTextArea('Descrição'),
                'coust' => new Fieldmanager_TextField('Preço'),
                'email' => new Fieldmanager_TextField('E-mail'),
            ),
        ));
        $fmUser->add_meta_box('Dados do Estabelecimento', $this->cpt, 'normal', 'high');

        $fmAddress = new Fieldmanager_Group(array(
            'name' => 'estab_address',
            'label'          => 'Localização',
            'children' => array(
                'country' => new Fieldmanager_TextField('País'),
                'state' => new Fieldmanager_TextField('Estado'),
                'city' => new Fieldmanager_TextField('Cidade'),
                'address' => new Fieldmanager_TextField('Endereço'),
                'address_number' => new Fieldmanager_TextField('N°'),
                'neighborhood' => new Fieldmanager_TextField( 'Bairro' ),
                'cep' => new Fieldmanager_TextField( 'cep' ),
            ),
        ));
        $fmAddress->add_meta_box('Endereços', $this->cpt, 'normal', 'high');

        $fmImages = new Fieldmanager_Group(array(
            'name' => 'estab_img',
            'label' => ' ',
            'label_macro' => array('%s', 'legend'),
            'limit' => 50,
            'add_more_label' => 'Adicionar Imagem',
            'children' => array(
                'img' => new Fieldmanager_Media(),
                'legend' => new Fieldmanager_TextField('Legenda'),
            ),
        ));
        $fmImages->add_meta_box('Imagens', $this->cpt, 'normal', 'high');

        $fmPhones = new Fieldmanager_Group(array(
            'name' => 'estab_phones',
            'label'          => ' ',
            'label_macro'    => array('%s', 'number'),
            'sortable'       => true,
            'limit'          => 5,
            'collapsible'    => true,
            'collapsed'      => true,
            'add_more_label' => 'Adicionar conteúdo',
            'group_is_empty' => function( $values ) { return empty( $values['number'] ); },
            'children' => array(
                'ddi' => new Fieldmanager_TextField('DDI'),
                'ddd' => new Fieldmanager_TextField('DDD'),
                'number' => new Fieldmanager_TextField( 'Número' ),
                'principal' => new Fieldmanager_Checkbox('Telefone Pricipal')
            )
        ));
        $fmPhones->add_meta_box('Telefones', $this->cpt, 'normal', 'high');
    }

    /**
     * Action Save Establisment CPT
     *
     * @param $post_ID
     * @param $post
     * @param $update
     */
    public function ActionSaveEstablismentCPT( $post_ID, $post, $update ) : void
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( is_admin() && $this->cpt === $post->post_type && function_exists('wpcom_vip_purge_edge_cache_for_url') ) {
            wpcom_vip_purge_edge_cache_for_url( site_url( 'stablishment-ajax' ) );
        }
    }

    /**
     * Establisment Ajax Add Rewrite Rules
     */
    public function EstablismentAjaxAddRewriteRules() : void
    {
        add_rewrite_rule(
            '^stablishment-ajax/?$',
            'index.php',
            'top'
        );
    }

    /**
     * Establisment Action Request
     *
     * @param $request
     * @return string|null
     */
    public function EstablismentActionRequest( $request )
    {
        if ( 'stablishment-ajax' === $request->request ) {
            switch ($_REQUEST['action']){
                case 'updateEstablisment':
                    return self::updateEstablisment();
                    break;

                case 'uploadImages':
                    return self::uploadImages();
                    break;

                case 'reorderImages':
                    return self::reorderImages();
                    break;

                case 'deleteImage':
                    return self::deleteImage();
                    break;

                default;
                    break;
            }
            exit();
        }

    }

    /**
     * Update User Datas
     *
     * @param null $action
     * @return string
     */
    public function updateEstablisment($action = null) : string
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'Establisment_nounce' ) ) {
            return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
        }

        $userID = (isset($_REQUEST['userid'])) ? sanitize_text_field($_REQUEST['userid']) : null;

        $coust = (isset($_REQUEST['coust'])) ? sanitize_text_field($_REQUEST['coust']) : null;
        $email = (isset($_REQUEST['email'])) ? sanitize_text_field($_REQUEST['email']) : null;
        $description = (isset($_REQUEST['description'])) ?  $_REQUEST['description'] : null;
        $urlreturn = (isset($_REQUEST['urlreturn'])) ?  $_REQUEST['urlreturn'] : null;

        $name = (isset($_REQUEST['title'])) ?  sanitize_text_field($_REQUEST['title']) : null;
        if(!$name){
            return wp_send_json(array(
                'message' => 'O campo Nome é obrigatório',
                'class' => 'alert,alert-danger'
            ));
        }

        $args = array(
            'name' => $name,
            'description' => $description,
            'coust' => $coust,
            'email' => $email,
        );

        $addressArgs = array(
            'country' => (isset($_REQUEST['address__country'])) ? sanitize_text_field($_REQUEST['address__country']) : '',
            'state' => (isset($_REQUEST['address__state'])) ? sanitize_text_field($_REQUEST['address__state']) : '',
            'city' => (isset($_REQUEST['address__city'])) ? sanitize_text_field($_REQUEST['address__city']) : '',
            'address' => (isset($_REQUEST['address__address'])) ? sanitize_text_field($_REQUEST['address__address']) : '',
            'address_number' => (isset($_REQUEST['address__address_number'])) ? sanitize_text_field($_REQUEST['address__address_number']) : '',
            'neighborhood' => (isset($_REQUEST['address__neighborhood'])) ? sanitize_text_field($_REQUEST['address__neighborhood']) : '',
            'cep' => (isset($_REQUEST['address__cep'])) ? sanitize_text_field($_REQUEST['address__cep']) : '',
        );

        if ( ! function_exists( 'post_exists' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/post.php' );
        }

        $title_stablishment = $userID . ' - ' . $name;
        $stablishmentID = post_exists($title_stablishment, '', '', $this->cpt);

        $phonesArgs = array();
        $pdCount = 0;
        foreach ($_REQUEST as $rkey => $request){
            if(strpos($rkey, 'phone') !== false && strpos($rkey, 'XXX') === false){
                $indexNumber = filter_var($rkey, FILTER_SANITIZE_NUMBER_INT);
                if(strpos($rkey,'ddd') !== false){
                    $indexKey = 'ddd';
                }elseif(strpos($rkey,'ddi') !== false){
                    $indexKey = 'ddi';
                }elseif(strpos($rkey,'number') !== false){
                    $indexKey = 'number';
                }
                $phonesArgs[$indexNumber][$indexKey] = $request;
            }

            if(strpos($rkey,'tax_partner') !== false){
                $append = $pdCount > 0;
                wp_set_object_terms((int) $stablishmentID, (int) sanitize_text_field($_REQUEST[$rkey]), 'partner_add', $append);
                $pdCount++;
            }
        }

        if($pdCount === 0){
            $postTermsPartner = get_the_terms($stablishmentID, 'partner_add');
            if(isset($postTermsPartner, $postTermsPartner[0])){
                wp_remove_object_terms( $stablishmentID, $postTermsPartner[0]->term_id, 'partner_add' );
            }
        }

        foreach ($phonesArgs as $allItems){
            foreach ($allItems as $item => $item_value){
                if(empty($item_value)){
                    return wp_send_json(array(
                        'message' => 'O campo '.$item.' é obrigatório.',
                        'class' => 'alert,alert-danger'
                    ));
                }
            }
        }

        $actionstate = 'inserido';
        if($stablishmentID){
            wp_update_post( array(
                'ID'         => $stablishmentID,
            ));
            $actionstate = 'atualizado';
        }else{
            $stablishmentID = wp_insert_post(array(
                'post_title' => $title_stablishment,
                'post_name' => $name,
                'post_type' => $this->cpt,
                'post_content' => $name,
                'post_status' => 'pending'
            ));
        }

        $term_id = wp_insert_term($userID, 'partner_user', array(
            'description' => '',
            'slug' => '',
        ));

        if (!is_wp_error($term_id)) {
            $term_id = $term_id['term_id'];
        } else {
            $term_id = $term_id->error_data['term_exists'];
        }

        wp_set_object_terms($stablishmentID, $term_id, 'partner_user');

        update_post_meta( $stablishmentID, 'estab_fields', $args );
        update_post_meta( $stablishmentID, 'estab_address', $addressArgs );
        update_post_meta( $stablishmentID, 'estab_phones', $phonesArgs );

        return wp_send_json(array(
            'message' => 'Estabelecimento ' . $actionstate . ' com sucesso!',
            'class' => 'alert,alert-success',
            'status' => 'ok',
            'url' => $urlreturn.'/form/'.$stablishmentID,
            'id' => $stablishmentID
        ));
    }

    /**
     * Upload Images
     *
     * @return string
     */
    public function uploadImages() : string
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'Establisment_nounce' ) ) {
            return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
        }
        $postID = (isset($_REQUEST['postID'])) ? sanitize_text_field($_REQUEST['postID']) : null;

        require_once (ABSPATH . 'wp-admin/includes/image.php');
        require_once (ABSPATH . 'wp-admin/includes/file.php');
        require_once (ABSPATH . 'wp-admin/includes/media.php');

        $imageID = wp_handle_upload($_FILES['establishmentImages'], array('test_form' => FALSE));
        $attachment = array(
            'guid'           => $imageID['url'],
            'post_mime_type' => $_FILES['establishmentImages']['type'],
            'post_title'     => $_FILES['establishmentImages']['name'],
            'post_content'   => '',
            'post_status'    => 'inherit'
        );

        $attachmentID = wp_insert_attachment( $attachment, $imageID['file'], $postID );
        if ( !is_wp_error( $attachmentID )) {
            $attach_meta = wp_generate_attachment_metadata( $attachmentID, $imageID['file'] );
            wp_update_attachment_metadata( $attachmentID, $attach_meta);
        }

        $attachmentImages = array_shift(get_post_meta($postID, 'estab_img'));
        $attachmentImages[] = array(
            'img' => $attachmentID,
        );

        update_post_meta( $postID, 'estab_img', $attachmentImages );

        return wp_send_json(array(
            'status' => 'ok',
            'image_url' => wp_get_attachment_image_url($attachmentID, 'thumbnail'),
            'image_id' => $attachmentID,
        ));
    }

    public function reorderImages()
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'Establisment_nounce' ) ) {
            return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
        }
        $postID = (isset($_REQUEST['postID'])) ? sanitize_text_field($_REQUEST['postID']) : null;
        $positions = (isset($_REQUEST['positions'])) ? $_REQUEST['positions'] : null;

        $imagesOrderer = array();
        foreach (json_decode($positions) as $p){
            $imagesOrderer[$p[0]] = array(
                'img' => $p[1]
            );
        }

        $imagesOrderer = array_values($imagesOrderer);
        update_post_meta( $postID, 'estab_img', $imagesOrderer );

        return wp_send_json(array(
            'status' => 'ok',
            'message' => 'Lista reordenada',
        ));
    }

    public function deleteImage()
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'Establisment_nounce' ) ) {
            return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
        }

        $postID = (isset($_REQUEST['postID'])) ? sanitize_text_field($_REQUEST['postID']) : null;
        $imageId = (isset($_REQUEST['imageId'])) ? sanitize_text_field($_REQUEST['imageId']) : null;
        $imgPosition = (isset($_REQUEST['imgPosition'])) ? sanitize_text_field($_REQUEST['imgPosition']) : null;

        $getIMages = get_post_meta($postID, 'estab_img')[0];
        unset($getIMages[(int) $imgPosition]);

        $getIMages = array_values($getIMages);

        update_post_meta( $postID, 'estab_img', $getIMages );

        wp_delete_attachment( (int) $imageId, true);

        return wp_send_json(array(
            'status' => 'ok',
            'message' => 'Imagem deletada com sucesso.',
        ));
    }

    /**
     * Register Taxonomies
     */
    public function RegisterTaxonomies() : void
    {
        $taxonomies = array(
            'partner_user' => array('label' => 'Anfitrião'),
            'partner_add' => array('label' => 'Adicionais'),
        );

        foreach ($taxonomies as $tkey => $tax){
            self::CreateTaxonomy(array(
                'taxonomy' => $tkey,
                'label' => $tax['label'],
                'cpt' => $this->cpt,
            ));
        }
    }

    /**
     * Tax Metas
     *
     * @throws FM_Developer_Exception
     */
    public function TaxMetas() : void
    {
        $fm_times = new Fieldmanager_Group('Informações Gerais', array(
            'name' => 'info',
            'serialize_data' => false,
            'add_to_prefix' => false,
            'children' => array(
                'icon' => new Fieldmanager_TextField('ícone'),
            ),
        ));
        $fm_times->add_term_meta_box(' ', array(
            'partner_add',
        ));
    }

    /**
     * Iterate Terms
     *
     * @param $tax
     */
    public function IterateTerms($tax) : void
    {
        $terms = self::getTagEstablishments();

        foreach ($terms as $term) {
            $term_id = wp_insert_term($term['item'], $tax);

            if (!is_wp_error($term_id)) {
                $term_id = $term_id['term_id'];
            } else {
                $term_id = $term_id->error_data['term_exists'];
            }

            update_term_meta($term_id, 'icon', $term['icon']);
        }
    }

}

