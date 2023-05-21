<?php
/**
 * Class CustomUser
 */
class CustomUser {
    use CustomersUtils;

    /**
     * CustomUser constructor.
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
        add_filter( 'theme_page_templates', array( $this, 'HookTemplatesPageList' ), 10, 4 );
        add_filter( 'page_template', array( $this, 'CustomUsersPanelTemplate' ) );
        add_filter( 'script_loader_tag', array( $this, 'AddAttrType' ) , 10, 3);
        add_action( 'wp_enqueue_scripts', array( $this, 'CustomUserEnqueue' ) );
        add_action( 'init', array( $this, 'CustomUserAjaxAddRewriteRules' ), 10 );
        add_action( 'parse_request', array( $this, 'CustomUserActionRequest' ), 10, 1 );
        add_action( 'save_post', array( $this, 'ActionSaveCustomUserCPT' ), 10, 3 );
        add_action( 'fm_user', array( $this, 'MetaboxCustomUser') );
        add_action( 'init', array( $this, 'CustomersRewriteTags' ) );
        add_action( 'wp_head', array( $this, 'CustomUserEnqueueStyles' ) );
        add_action( 'dv_blank_navbar_coll', function(){
            include_once(CustomerPATH . '/templates/login.php');
        });
        add_action('wp_footer', function(){
            include(CustomerPATH . '/templates/parts/form_login.php');
        });
    }

    public function FavoriteItem()
    {
        if(!is_user_logged_in()) return false;

        $current_user = wp_get_current_user();

        $id = sanitize_text_field($_REQUEST['id']) ?? null;
        $meta = get_user_meta($current_user->ID, 'custom') ?? null;
        $favorites = (json_decode($meta[0]['favorite_items'])) ?? array();

        $findItem = array_search($id, $favorites);

        if(is_int($findItem)){
            unset($favorites[$findItem]);
            $favorites = array_values($favorites);
        }else{
            $favorites[] = $id;
        }

        update_user_meta($current_user->ID, 'custom', array('favorite_items' => wp_json_encode($favorites)));

        return wp_send_json(array(
            'status' => 'ok',
            'message' => 'Adicionado a galeria de favoritos.',
        ));
    }

    /**
     * Add Metaboxes and field to CustomUsers custom post type
     *
     * @throws FM_Developer_Exception
     */
    public function MetaboxCustomUser () : void
    {
        $fmAddress = new Fieldmanager_Group(array(
            'name' => 'user_address',
            'label'          => 'Endereço',
            'label_macro'    => array('%s', 'address'),
            'sortable'       => true,
            'limit'          => 5,
            'collapsible'    => true,
            'collapsed'      => false,
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
        $fmAddress->add_user_form( ' ' );

        $fmPhones = new Fieldmanager_Group(array(
            'name' => 'user_phones',
            'label'          => 'Telefone',
            'label_macro'    => array('%s', 'number'),
            'sortable'       => true,
            'limit'          => 5,
            'collapsible'    => true,
            'collapsed'      => false,
            'add_more_label' => 'Adicionar conteúdo',
            'group_is_empty' => function( $values ) { return empty( $values['number'] ); },
            'children' => array(
                'ddi' => new Fieldmanager_TextField('DDI'),
                'ddd' => new Fieldmanager_TextField('DDD'),
                'number' => new Fieldmanager_TextField( 'Número' ),
                'principal' => new Fieldmanager_Checkbox('Telefone Pricipal')
            )
        ));
        $fmPhones->add_user_form( ' ' );

        $fmUser = new Fieldmanager_Group(array(
            'name' => 'user_fields',
            'label' => 'Dados Pessoais',
            'children' => array(
                'profile' => new Fieldmanager_Media('Imagem do perfil'),
                'cpf' => new Fieldmanager_TextField('cpf'),
                'rg' => new Fieldmanager_TextField('rg'),
            ),
        ));
        $fmUser->add_user_form( ' ' );

        $fmCustom = new Fieldmanager_Group(array(
            'name' => 'custom',
            'label' => 'Customizações',
            'children' => array(
                'favorite_items' => new Fieldmanager_TextField('Favoritos'),
            )
        ));
        $fmCustom->add_user_form( ' ' );
    }

    /**
     * Hook Templates Page List
     *
     * @param $post_templates
     * @param $wp_theme
     * @param $post
     * @param $post_type
     * @return mixed
     */
    function HookTemplatesPageList( $post_templates, $wp_theme, $post, $post_type ) {
        $post_templates['user-register.php'] = __('Cadastro de clientes');
        $post_templates['userpanel'] = __('Painel do Cliente');
        return $post_templates;
    }

    /**
     * Customers Rewrite Tags
     */
    public function CustomersRewriteTags() : void
    {
        add_rewrite_tag( '%panel%', '([^/]*)' );
        add_rewrite_tag( '%partner%', '([^/]*)' );
        add_rewrite_tag( '%action%', '([^/]*)' );
        add_rewrite_tag( '%postid%', '([^/]*)' );
        add_rewrite_rule(
            '^admin/([^/]*)/?([^/]*)/?([^/]*)/?([^/]*)/?([^/]*)/?$',
            'index.php?pagename=admin&panel=$matches[1]&partner=$matches[2]&action=$matches[3]&postid=$matches[4]',
            'top'
        );
    }

    /**
     * Update User Datas
     *
     * @param null $action
     * @return string
     */
    public function UpdateUserDatas($action = null) : string
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if ( ! wp_verify_nonce( $nonce, 'CustomUser_nounce' ) ) {
            return wp_send_json(new WP_Error('wperro', 'Nounce Inválido'));
        }

        $userID = (isset($_REQUEST['userid'])) ? sanitize_text_field($_REQUEST['userid']) : null;

        $user_cpf = (isset($_REQUEST['user_cpf'])) ?  sanitize_text_field($_REQUEST['user_cpf']) : null;
        $user_rg = (isset($_REQUEST['user_rg'])) ?  sanitize_text_field($_REQUEST['user_rg']) : null;
        $name = (isset($_REQUEST['user_name'])) ?  sanitize_text_field($_REQUEST['user_name']) : null;
        if(!$name){
            return wp_send_json(array(
                'message' => 'O campo Nome é obrigatório',
                'class' => 'alert,alert-danger'
            ));
        }

        $lastname = (isset($_REQUEST['user_lastname'])) ? sanitize_text_field($_REQUEST['user_lastname']) : null;
        if(!$lastname){
            return wp_send_json(array(
                'message' => 'O campo Nome é obrigatório',
                'class' => 'alert,alert-danger'
            ));
        }

        $email = (isset($_REQUEST['user_email'])) ? sanitize_text_field($_REQUEST['user_email']) : null;
        if(!$email){
            return wp_send_json(array(
                'message' => 'O campo e-mail é obrigatório',
                'class' => 'alert,alert-danger'
            ));
        }

        $pass = (isset($_REQUEST['user_pass'])) ? sanitize_text_field($_REQUEST['user_pass']) : null;

        if(isset($pass)){
            $confirm_pass = (isset($_REQUEST['confirm_user_pass'])) ? sanitize_text_field($_REQUEST['confirm_user_pass']) : null;
            if(isset($pass) && strlen($pass) < 1 ){
                return wp_send_json(array(
                    'message' => 'O campo senha é obrigatório',
                    'class' => 'alert,alert-danger'
                ));
            }else if(isset($pass) && $pass !== $confirm_pass){
                return wp_send_json(array(
                    'message' => 'Senhas não conferem',
                    'class' => 'alert,alert-danger'
                ));
            }

            if(strlen($pass) < 8){
                return wp_send_json(array(
                    'message' => 'Senha precisa ter pelo menos 8 caracteres',
                    'class' => 'alert,alert-danger'
                ));
            }
        }

        $args = array(
            'rg' => $user_rg,
            'cpf' => $user_cpf
        );

        $countAddress = (isset($_REQUEST['countAddress'])) ?  sanitize_text_field($_REQUEST['countAddress']) : 0;
        $addressArgs = array();
        for ($i = 0; $i < $countAddress; $i++){
            array_push($addressArgs, array(
                'country' => (isset($_REQUEST['address_'.$i.'_country'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_country']) : '',
                'state' => (isset($_REQUEST['address_'.$i.'_state'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_state']) : '',
                'city' => (isset($_REQUEST['address_'.$i.'_city'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_city']) : '',
                'address' => (isset($_REQUEST['address_'.$i.'_address'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_address']) : '',
                'address_number' => (isset($_REQUEST['address_'.$i.'_address_number'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_address_number']) : '',
                'neighborhood' => (isset($_REQUEST['address_'.$i.'_neighborhood'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_neighborhood']) : '',
                'cep' => (isset($_REQUEST['address_'.$i.'_cep'])) ? sanitize_text_field($_REQUEST['address_'.$i.'_cep']) : '',
            ));
        }

        foreach ($addressArgs as $allItems){
            foreach ($allItems as $item => $item_value){
                if(empty($item_value)){
                    return wp_send_json(array(
                        'message' => 'O campo '.$item.' é obrigatório.',
                        'class' => 'alert,alert-danger'
                    ));
                }
            }
        }

        $countPhones = (isset($_REQUEST['countPhones'])) ?  sanitize_text_field($_REQUEST['countPhones']) : 0;
        $phonesArgs = array();
        for ($i = 0; $i < $countPhones; $i++){
            array_push($phonesArgs, array(
                'ddi' => (isset($_REQUEST['user_phones_ddi_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_ddi_'.$i]) : '',
                'ddd' => (isset($_REQUEST['user_phones_ddd_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_ddd_'.$i]) : '',
                'number' => (isset($_REQUEST['user_phones_number_'.$i])) ? sanitize_text_field($_REQUEST['user_phones_number_'.$i]) : '',
            ));
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

        $newUser = false;
        if($userID){
            wp_update_user( array(
                'ID' => $userID,
                'first_name' => $name,
                'last_name' => $lastname,
            ) );
        }else{
            $userID = wp_insert_user( array(
                'user_login' => $email,
                'user_pass' => $pass,
                'user_email' => $email,
                'first_name' => $name,
                'last_name' => $lastname,
                'display_name' => $name,
                'role' => 'editor'
            ));
            if(is_wp_error($userID)){
                if(isset($userID->errors['existing_user_email'])){
                    return wp_send_json(array(
                        'message' => 'Já existe um usuário com este e-mail cadastrado',
                        'class' => 'alert,alert-warning',
                        'id' => $userID
                    ));
                }
            }
            $newUser = true;
        }

        update_user_meta( $userID, 'user_fields', $args );
        update_user_meta( $userID, 'user_address', $addressArgs );
        update_user_meta( $userID, 'user_phones', $phonesArgs );

        if($newUser){
            self::loginUser(array(
                'email' => $email,
                'pass' => $pass
            ), true);
        }

        return wp_send_json(array(
            'message' => 'Usuário atualizado com sucesso!',
            'class' => 'alert,alert-success',
            'id' => $userID
        ));
    }

    /**
     * Customer Enqueue Styles
     */
    public function CustomUserEnqueueStyles() : void
    {
        wp_enqueue_style('custom-users-cpt-css', CustomerURL . '/assets/public/css/style.css');
    }

    /**
     * loginUser
     *
     * @param array $args
     * @param null $escape_nonce
     * @return string|null
     */
    public function loginUser($args = array(), $escape_nonce = null) : string | null
    {
        $nonce = isset($_REQUEST['nounce']) ? sanitize_text_field($_REQUEST['nounce']) : '';
        if (!$escape_nonce && !wp_verify_nonce( $nonce, 'CustomUser_nounce' ) ) {
            return wp_send_json(new WP_Error('Erro', 'Nounce Inválido'));
        }

        $user = (isset($_REQUEST['userLogin'])) ? sanitize_text_field($_REQUEST['userLogin']) : null;
        $pass = (isset($_REQUEST['userPass'])) ? sanitize_text_field($_REQUEST['userPass']) : null;

        if($escape_nonce){
            $user = $args['email'];
            $pass = $args['pass'];
        }

        if(empty($user) || empty($pass)){
            return wp_send_json(array(
                'message' => 'Campos obrigatórios',
                'class' => 'alert,alert-danger'
            ));
        }

        $user = wp_authenticate($user, $pass);
        if(!is_wp_error($user)) {
            $first_name = $user->user_nicename;
            wp_set_current_user( $user->ID, $user->user_login );
            wp_set_auth_cookie( $user->ID );
            $current_user = wp_get_current_user();
            return wp_send_json(array(
                'message' => 'Saudações ' . $current_user->first_name . '!',
                'url' => site_url().'/admin',
                'status' => 'ok',
                'class' => 'alert,alert-success'
            ));
        } else {
            return wp_send_json(array(
                'message' => 'Dados inválidos',
                'class' => 'alert,alert-danger'
            ));
        }

    }

    /**
     * Customers Panel Template
     *
     * @param $page_template
     * @return string
     */
    function CustomUsersPanelTemplate( $page_template ){
        if ( get_page_template_slug() == 'user-register.php' ) {
            $page_template = CustomerPATH . 'templates/user-register.php';
        }
        if ( get_page_template_slug() == 'userpanel' ) {
            $page_template = CustomerPATH . 'templates/user-panel.php';
        }
        return $page_template;
    }

    /**
     * CustomUser Ajax Add Rewrite Rules
     */
    public function CustomUserAjaxAddRewriteRules() : void
    {
        add_rewrite_rule(
            '^custom-user-ajax/?$',
            'index.php',
            'top'
        );
    }

    /**
     * CustomUser Action Request
     *
     * @param $request
     * @return string|null
     */
    public function CustomUserActionRequest( $request )
    {
        if ( 'custom-user-ajax' === $request->request ) {

            switch ($_REQUEST['action']){
                case 'UploadProfileImage':
                    return self::UploadProfileImage();
                    break;

                case 'UpdateUserDatas':
                    return self::UpdateUserDatas();
                    break;

                case 'loginUser':
                    return self::loginUser();
                    break;

                case 'userLogout':
                    return self::UserLogout();
                    break;

                case 'updatePass':
                    return self::updatePass();
                    break;

                case 'FavoriteItem':
                    return self::FavoriteItem();
                    break;

                default;
                    break;
            }
            exit();
        }
    }

    /**
     * Action Save CustomUser CPT
     *
     * @param $post_ID
     * @param $post
     * @param $update
     */
    public function ActionSaveCustomUserCPT( $post_ID, $post, $update ) : void
    {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( is_admin() && function_exists('wpcom_vip_purge_edge_cache_for_url') ) {
            wpcom_vip_purge_edge_cache_for_url( site_url( 'custom-user-ajax' ) );
        }
    }

    /**
     * Add Attribute Type
     *
     * @param $tag
     * @param $handle
     * @param $src
     * @return string
     */
    public function AddAttrType($tag, $handle, $src) : string
    {
        if ( 'stablishments-cpt-scripts' !== $handle && 'CustomUsers-scripts' !== $handle && 'CustomUsers-user-scripts' !== $handle ) {
            return $tag;
        }
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
        return $tag;
    }

    public function CustomUserEnqueue( ) : void
    {
        wp_enqueue_script( 'CustomUsers-scripts', CustomerURL . 'assets/public/js/scripts.js', array(), false, true );
        wp_enqueue_script( 'CustomUsers-user-scripts', CustomerURL . 'assets/public/js/single.js', array(), false, true );

        $ajax_slug = 'CustomUser';
        $vars = [
            'url'           => site_url('custom-user-ajax'),
            'nounce'         => wp_create_nonce( $ajax_slug . "_nounce" ),
            'action'         => 'CustomUserActionRequest',
            'CustomUser_ajax'   => $ajax_slug,
        ];

        wp_localize_script('CustomUsers-scripts', $ajax_slug.'_js', $vars);
    }

    /**
     * Logout
     */
    private function UserLogout()
    {
        wp_logout();
        return wp_send_json(array(
            'message' => 'Logout successfully!'
        ));
    }

}

