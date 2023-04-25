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
            wp_enqueue_script( 'stablishments-cpt-scripts', CustomerURL . '/assets/public/js/establishments.js', array(), false, true );
            wp_localize_script('stablishments-cpt-scripts', $ajax_slug.'_js', $vars);
        }

    }

    /**
     * Establisment Enqueue Styles
     */
    public function EstablismentEnqueueStyles() : void
    {
        wp_enqueue_style('stablishments-cpt-css', CustomerURL . '/assets/public/css/style.css');
    }

    /**
     * Add Metaboxes and field to Establishments custom post type
     *
     * @throws FM_Developer_Exception
     */
    public function MetaboxEstablismentCPT () : void
    {
        $fmUser = new Fieldmanager_Group(array(
            'name' => 'user_fields',
            'children' => array(
                'name' => new Fieldmanager_TextField('Nome'),
                'lastname' => new Fieldmanager_TextField('sobrenome'),
                'email' => new Fieldmanager_TextField('E-mail'),
            ),
        ));
        $fmUser->add_meta_box('Dados de Cadastro', $this->cpt, 'normal', 'high');

        $fmPass = new Fieldmanager_Group(array(
            'name' => 'user_pass',
            'children' => array(
                'pass' => new Fieldmanager_Password('Senha'),
            ),
        ));
        $fmPass->add_meta_box('Senha', $this->cpt, 'normal', 'high');

        $fmAddress = new Fieldmanager_Group(array(
            'name' => 'user_address',
            'label'          => ' ',
            'label_macro'    => array('%s', 'address'),
            'sortable'       => true,
            'limit'          => 5,
            'collapsible'    => true,
            'collapsed'      => true,
            'add_more_label' => 'Adicionar conteúdo',
            'group_is_empty' => function( $values ) { return empty( $values['address'] ); },
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

        $fmPhones = new Fieldmanager_Group(array(
            'name' => 'user_phones',
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

                default;
                    break;
            }
            exit();
        }

    }

    /**
     * Update Pass
     *
     * @return string
     */
    public function updatePass() : string
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'Establisment_nounce' ) ) {
            return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
        }

        $oldPassword = (isset($_REQUEST['oldPassword'])) ? sanitize_text_field($_REQUEST['oldPassword']) : null;
        $newPassword = (isset($_REQUEST['newPassword'])) ? sanitize_text_field($_REQUEST['newPassword']) : null;
        $confirmNewPassword = (isset($_REQUEST['confirmNewPassword'])) ? sanitize_text_field($_REQUEST['confirmNewPassword']) : null;
        $userID = (isset($_REQUEST['userPassword'])) ? sanitize_text_field($_REQUEST['userPassword']) : null;

        if(empty($newPassword) || is_null($newPassword) || $newPassword !== $confirmNewPassword){
            return wp_send_json(array(
                'message' => 'Senhas não conferem',
                'class' => 'alert,alert-danger'
            ));
        }

        if(strlen($newPassword) < 8){
            return wp_send_json(array(
                'message' => 'Senha precisa conter mais que 8 caracteres',
                'class' => 'alert,alert-danger'
            ));
        }

        $pass = get_post_meta($userID, 'user_pass');
        if(isset($pass)){
            $pass = array_shift($pass)['pass'];
        }

        if($pass !== $oldPassword){
            return wp_send_json(array(
                'message' => 'Senha incorreta',
                'class' => 'alert,alert-danger'
            ));
        }

        update_post_meta($userID, 'user_pass', array(
            'pass' => $newPassword
        ));

        return wp_send_json(array(
            'message' => 'Senha atualizada com sucesso',
            'class' => 'alert,alert-success'
        ));
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

        $name = (isset($_REQUEST['name'])) ?  sanitize_text_field($_REQUEST['name']) : null;
        if(!$name){
            return wp_send_json(array(
                'message' => 'O campo Nome é obrigatório',
                'class' => 'alert,alert-danger'
            ));
        }

        $country = (isset($_REQUEST['address__country'])) ? sanitize_text_field($_REQUEST['address__country']) : '';
        $state = (isset($_REQUEST['address__state'])) ? sanitize_text_field($_REQUEST['address__state']) : '';
        $city = (isset($_REQUEST['address__city'])) ? sanitize_text_field($_REQUEST['address__city']) : '';
        $address = (isset($_REQUEST['address__address'])) ? sanitize_text_field($_REQUEST['address__address']) : '';
        $address_number = (isset($_REQUEST['address__address_number'])) ? sanitize_text_field($_REQUEST['address__address_number']) : '';
        $neighborhood = (isset($_REQUEST['address__neighborhood'])) ? sanitize_text_field($_REQUEST['address__neighborhood']) : '';
        $cep = (isset($_REQUEST['address__cep'])) ? sanitize_text_field($_REQUEST['address__cep']) : '';

        if ( ! function_exists( 'post_exists' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/post.php' );
        }

        $title_stablishment = $userID . ' - ' . $name;
        $stablishmentID = post_exists($title_stablishment, '', '', $this->cpt);

        if($stablishmentID){
            wp_update_post( array(
                'ID'         => $stablishmentID,
            ));
        }else{
            $stablishmentID = wp_insert_post(array(
                'post_title' => $title_stablishment,
                'post_name' => $name,
                'post_type' => $this->cpt,
                'post_content' => 'description',
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

        return wp_send_json(array(
            'message' => 'Estabelecimento cadastrado com sucesso!',
            'class' => 'alert,alert-success',
            'id' => $stablishmentID
        ));

        die();

        $newUser = false;
        if($postID){
            wp_update_post( array(
                'ID'         => $postID,
                'post_title' => $email
            ) );
        }else{
            if(!self::userExists($email)){
                $postID = wp_insert_post(array(
                    'post_title' => $email,
                    'post_content' => $name . ' ' . $lastname,
                    'post_name' => $name,
                    'post_status' => 'publish'
                ));
                if($postID){
                    $newUser = true;
                }
            }else{
                return wp_send_json(array(
                    'message' => 'Já existe um usuário com este e-mail cadastrado',
                    'class' => 'alert,alert-warning'
                ));
            }

        }

        update_post_meta( $postID, 'user_fields', $args );
        update_post_meta( $postID, 'user_address', $addressArgs );
        update_post_meta( $postID, 'user_phones', $phonesArgs );
        if(isset($pass)){
            update_post_meta( $postID, 'user_pass', array(
                'pass' => $pass
            ));
        }

        if($newUser){
            self::loginUser(array(
                'user' => $email,
                'pass' => $pass
            ), true);
        }


        return wp_send_json(array(
            'message' => 'Usuário atualizado com sucesso!',
            'class' => 'alert,alert-success',
            'id' => $postID
        ));
    }

    /**
     * Register Taxonomies
     */
    public function RegisterTaxonomies() : void
    {
        $taxonomies = array(
            'partner_user' => array('label' => 'Anfitrião'),
        );

        foreach ($taxonomies as $tkey => $tax){
            self::CreateTaxonomy(array(
                'taxonomy' => $tkey,
                'label' => $tax['label'],
                'cpt' => $this->cpt,
            ));
        }
    }

}

