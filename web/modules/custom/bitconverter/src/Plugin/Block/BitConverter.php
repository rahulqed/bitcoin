<?php
/**
 * @file
 * Contains \Drupal\bitconverter\Plugin\Block\BitConverter.
 */
namespace Drupal\bitconverter\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\bitconverter\Services\BitService;
/**
 * Provides a 'currency' block.
 *
 * @Block(
 *   id = "bit_converter",
 *   admin_label = @Translation("Bit converter Block"),
 *   category = @Translation("Bit converter Block")
 * )
 */
  class BitConverter extends BlockBase implements ContainerFactoryPluginInterface{

    protected $bitservice;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, BitService $bitservice){
      parent::__construct($configuration, $plugin_id, $plugin_definition);
      $this->bitservice = $bitservice;
    }

    public static function create (ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition){
      // new static() means "Call the constructor of the current class"
      return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('bitconverter.bitservice')
      );
    }

    public function blockForm($form, FormStateInterface $form_state) {
        $form['bimage'] = [
            '#type' => 'managed_file',
            '#title' => 'bimage',
            '#upload_location' => 'public://upload/bitconverter',
        ];
        $form['access_key'] = [
          '#type' => 'textfield',
          '#title' => 'access_key',
      ];


        return $form;
    }
    public function blockSubmit($form, FormStateInterface $form_state) {
        $c = $form_state->getValues();
        $this->setConfigurationValue('bimage',$c['bimage']);
        $this->setConfigurationValue('access_key',$c['access_key']);
      }
    public function build() {
        // //$configs=$this->getConfiguration();

        // // $image=$configs['bimage'];
        // // $image_uri = \Drupal\file\Entity\File::load($image[0]);
        // // //$image_uri->setPermanent();
        // // $image_uri->save();

        // // $form['title'] = [
        // //     '#type' => 'label',
        // //     '#title' => $this->t('Currency Calculator')
        // //   ];

        // // $form['description'] = [
        // //     '#type' => 'label',
        // //     '#title' => $this->t('Abhbjwdbsbciei'),
        // //   ];

        // // $form['textfields_container'] = [
        // //   '#type' => 'container',
        // //   '#attributes' => ['id' => 'textfields-container'],
        // // ];
        // // $form['amount'] = [
        // //     '#type' => 'textfield',
        // //     '#placeholder' => t('Enter Amount'),
        // //     '#ajax' => [
        // //       'callback' => '::updateDisplayAmount',
        // //       'event' => 'keyup',
        // //       'progress' => [
        // //         'type' => 'throbber',
        // //         'message' => t('Verifying entry...'),
        // //       ],
        // //     ],
        // //     // '#ajax' => array(s
        // //     //   'event' => 'keyup',
        // //     //   'callback' => '::updateDisplayAmount',
        // //     //   'wrapper' => 'textfields-container',
        // //     // ),
        // //   ];



        //   // $form['display_amount']['#prefix'] = '<div id="display-amount">';
        //   // $form['display_amount']['#suffix'] = '</div>';
        //   // $form['textfields_container']['display_amount'] = [
        //   //     '#type' => 'textfield',
        //   //     '#placeholder' => t('Enter Amount'),
        //   // ];

        // // $form['type_options1'] = [
        // //     '#type' => 'select',
        // //     '#options' => array('BITCOIN(BTC)' => t('BITCOIN(BTC)'),
        // //                       'BITCOINCASH(BCH)' => t('BITCOIN CASH(BCH)')),
        // //     '#value' => $this->t('BITCOIN(BTS)'),
        // // ];
        // // $form['type_options2'] = [
        // //     '#type' => 'select',
        // //     '#options' => array('USDOLLAR(USD)' => t('US DOLLAR(USD)'),
        // //                       'INDIA(RS)' => t('INDIA(RS)')),
        // //     '#value' => $this->t('INDIA(RS)'),
        // // ];
        // // $form['my_button'] = [
        // //     '#type' => 'submit',
        // //     '#value' => t('BUY NOW!'),
        // // ];
        // //Kint($form);
        // //return $form;


        // $form['changethis'] = [
        //   '#title' => $this->t("Choose something and explain why"),
        //   '#type' => 'select',
        //   '#options' => [
        //     'one' => 'one',
        //     'two' => 'two',
        //     'three' => 'three',
        //   ],
        //   '#ajax' => [
        //     // #ajax has two required keys: callback and wrapper.
        //     // 'callback' is a function that will be called when this element
        //     // changes.
        //     'callback' => '::promptCallback',
        //     // 'wrapper' is the HTML id of the page element that will be replaced.
        //     'wrapper' => 'replace-textfield-container',
        //   ],
        // ];

        // // The 'replace-textfield-container' container will be replaced whenever
        // // 'changethis' is updated.
        // $form['replace_textfield_container'] = [
        //   '#type' => 'container',
        //   '#attributes' => ['id' => 'replace-textfield-container'],
        // ];
        // $form['replace_textfield_container']['replace_textfield'] = [
        //   '#type' => 'textfield',
        //   '#title' => $this->t("Why"),
        // ];

        // // An AJAX request calls the form builder function for every change.
        // // We can change how we build the form based on $form_state.
        // $value = $form_state->getValue('changethis');
        // // The getValue() method returns NULL by default if the form element does
        // // not exist. It won't exist yet if we're building it for the first time.
        // if ($value !== NULL) {
        //   $form['replace_textfield_container']['replace_textfield']['#description'] =
        //     $this->t("Say why you chose '@value'", ['@value' => $value]);
        // }
        $form = \Drupal::formBuilder()->getForm('\Drupal\bitconverter\Form\ConveriosnForm');
        return $form;
    }

    public static function updateDisplayAmount(array $form, FormStateInterface $form_state){
      $form['amount']['disbale']= 'disabled';
      return $form;
      //print_r('working');exit();
      // $amount = $form_state->getValue('amount');
      // debug($amount, '$amount');
      // return [
      //   $form['display_amount']['#value'] = $amount
      // ];
      // $form['textfields_container']['display_amount']['#value'] = 'ananad';
      // return $form['textfields_container'];

      // // Fetching the data from the block placed area.
      // $amount = $form_state->getValue('amount');
      // $type_options1 = $form_state->getValue('type_options1');
      // $type_options2 = $form_state->getValue('type_options2');

      // $configs=$this->getConfiguration();

      // $access_key = $configs['access_key'];
      // $symbols = $type_options1 .','.$type_options2;
      // $result = $this->bitservice->getDetails($access_key, $symbols);
      // return $result;

  }
}