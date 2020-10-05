<!-- This is where we show the user's profile page. Two views: viewing own profile, viewing other's -->
<?php 
// if(pmpro_hasMembershipLevel('1,2,3,4,5,6,7,8,9,10'))
// {
?>

<div class="type-small profile-co-block__outer bg-lightblue type-white" id="ind-co">
  <div class="text-block--max-width profile-co-block__inner type-tiny">
    <div class="grid">
      <!-- My offer only for self profile -->
      <?php if (!isset($_GET["pu"])) { 
        $cur_u_i = get_current_user_id();
  
        $my_offers = dctit_list_offer($cur_u_i); ?>
        <?php if ( !(empty( $my_offers )) ) : ?>
          <div class="grid-item">
            <h1 class="type-med margin-btm--s">My offers</h1>
          </div>
        <?php endif ?>
        <?php foreach ($my_offers as $my_offer) { ?>
          <div class="slef-profile-2345 single-offer offer-id=<?php echo $com_offer['offer_id']; ?>">
            <!-- <div class="grid-item">
              <h2 class="type-small"><?php echo $my_offer['offer_title']; ?></h2>
            </div> -->
            <br>
            <div class="grid-item c-offer">
              <div class="profile-co-block" data-co-id="<?php echo $my_offer['offer_id']; ?>" data-co-author-id="<?php echo $my_offer['offer_author_id']; ?>">
                <h1 class='type-med margin-btm--s co-title'><?php echo $my_offer['offer_title']; ?></h1>
                <p class='co-details'><?php echo $my_offer['offer_details']; ?></p>
                <button class="type-tiny" data-editable=false>Edit</button>
                <button class="type-tiny" data-co-avail=<?php echo $my_offer['offer_availability']; ?>><?php if($my_offer['offer_availability'] == 1) { echo 'Enabled'; } else { echo 'Disabled' ;} ?></button>
                <button class="type-tiny" data-delete>Delete</button>
              </div>
            </div>
            <br>
          </div>
          <!-- <br><br> -->
  
        <?php } ?>
        <div id="confirm-delete" class="popup">
          <div class="popup-content">
            <span class="popup-close">&times;</span>
            <div class="profile-co-block__delete-confirm">
              <p>Are you sure you'd like to delete the Community Offer?</p>
              <button data-del-co>Yes, delete the offer</button>
              <button data-del-reject>No, return to my offers</button>
            </div>
          </div>
        </div>
  
        <!-- Submit a New Offer -->
        <div class="grid-item border-top--white margin-top--m">
          <h1 class="type-med margin-btm--s">Submit a new offer</h1>
        </div>
  
        <div class="grid-item">
          <p class="type-tiny">Use the button below to send us the details of your offer</p>
          <button class="type-tiny" data-create-new>Submit a Community Offer</button>
  
          <div class="profile-co-block__submit  add_new_offer-2345">
            <form class="type-small co-ind-form" action="" id="__createOffer">
              <input type="hidden" name="co_author_id" value="<?php echo $cur_u_i; ?>">
              <input type="text" name="co_title" placeholder="Offer title" required>
              <input type="textarea" name="co_details" placeholder="Offer description" required>
              <input class="type-tiny" type="submit" value="Submit">
            </form>
          </div>
        </div>
  
      <?php } else {
  
        $user_nick_name = $_GET["pu"];
        $login_name = str_replace('-', ' ', $user_nick_name);
        $user_id = get_user_by('login', $login_name);
  
      ?>
  
        <!-- Others available community offers -->
        <?php $com_offers = dctit_list_offer($user_id->ID); ?>
        <?php if ( !(empty( $com_offers )) ) : ?>
          <div class="grid-item">
            <h1 class="type-med margin-btm--s">Available Community Offers</h1>
          </div>
        <?php endif ?>
        <?php foreach ($com_offers as $com_offer) { ?>
          <div class="others-profile-2345">
            <div class="grid-item">
              <div class="profile-co-block" data-post-id="<?php echo $com_offer['offer_id']; ?>">
                <h2 class="type-med margin-btm--s"><?php echo $com_offer['offer_title']; ?></h2>
                <p><?php echo $com_offer['offer_details']; ?></p>
                <button data-post-id="<?php echo $com_offer['offer_id']; ?>" data-sender-id="<?php echo get_current_user_id(); ?>" data-recipient-id="<?php echo get_post_field('post_author', $com_offer['offer_id']); ?>" class="send_msg">Get in Touch</button>
              </div>
            </div>
            <br>
            <br>
          </div>
      <?php }
      } ?>

    </div>
  </div>
</div>

<?php 
// }
?>

<script>
  (function() {
    console.log('invoked');
    let __createOfferForm = jQuery('#__createOffer');
    let __updateOfferForm = jQuery('.__updateOffer');
    let __enableBtns = jQuery('[data-co-avail]');
    let __dataEditBtn = jQuery('[data-editable]');
    let __sendMessage = jQuery('.send_msg');
    let __createOffer = jQuery('[data-create-new]');

    let __deleteBtn = jQuery('[data-delete]');
    let __popup = jQuery('.popup');
    let __popupClose = jQuery('span.popup-close');

    // Create New Offer form when user click on "Submit a Community offer" button
    jQuery(__createOffer).click(function(e) {
      jQuery('.add_new_offer-2345').css('display', 'block');
    });

    // Send create offer request when user submit the "Create Offer" form
    __createOfferForm.submit(function(e) {
      e.preventDefault();
      var __createOfferFormData = {};
      jQuery.each(__createOfferForm.serializeArray(), function(i, field) {
        __createOfferFormData[field.name] = field.value
      });
      ajaxLoading();
      jQuery.ajax({
        type: 'POST',
        dataType: 'json',
        url: myAjax.ajaxurl,
        data: {
          action: 'add_coffer',
          ...__createOfferFormData
        },
        success: function(response) {
          if (response.type === 'success') {
            ajaxSuccess();
            setTimeout(function() {
              location.reload();
            }, 1000);
          } else {
            console.log('Request Not Succeed');
          }
        }
      })
    });

    // Listen to enable button's click event and send enable offer request
    __enableBtns.each(function(i, btn) {
      jQuery(btn).click(function(e) {
        let element = jQuery(this)
        let co_id = element.parent().data('co-id');
        let co_author_id = element.parent().data('co-author-id');
        let co_availx = Boolean(element.data('co-avail'));
        let post_data = {
          co_id,
          co_author_id
        };

        let co_avail = !co_availx ? 1 : 0;

        ajaxLoading();
        jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: myAjax.ajaxurl,
          data: {
            action: 'set_coffer_availability',
            co_id,
            co_author_id,
            co_avail
          },
          success: function(response) {
            if (response.type === 'success') {
              ajaxSuccess();
              setTimeout(function() {
                location.reload();
              }, 1000);
            } else {
              console.log('Request Not Succeed');
            }
          }
        })

      });

    });

    // Listen to delete button's click event and send delete offer request
    __deleteBtn.each(function(i, btn) {
      jQuery(btn).click(function(e) {
        let co_id = jQuery(this).parent().data('co-id');
        let co_author_id = jQuery(this).parent().data('co-author-id');

        __popup.css('display', 'block');

        let __confirm = jQuery('[data-del-co]');
        let __notDelete = jQuery('[data-del-reject]');

        __confirm.click(function(e) {
          destroyPopup();
          ajaxLoading();
          jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            url: myAjax.ajaxurl,
            data: {
              action: 'delete_co',
              co_id,
              co_author_id
            },
            success: function(response) {
              if (response.type === 'success') {
                ajaxSuccess();
                setTimeout(function() {
                  location.reload();
                }, 1000);
              } else {
                console.log('Request Not Succeed');
              }
            }
          });
        });

        jQuery(__notDelete).add(__popupClose).on('click', destroyPopup);
      });
    });

    // Listen to offer edit button's click event and generate a form
    jQuery(__dataEditBtn).each(function(i, btn) {
      jQuery(btn).click(function(e) {
        destroyOfferUpdateForm(__dataEditBtn);
        let editable = jQuery(this).data('editable');
        if (!editable) {
          generateOfferUpdateForm(this);
        }
        jQuery(this).data('editable', true);
      });
    });

    // Generate offer update form when a user click on the "Offer Edit" button
    function generateOfferUpdateForm(element) {
      let co_id = jQuery(element).parent().data('co-id');
      let co_author_id = jQuery(element).parent().data('co-author-id');
      let currentTitle = jQuery(element).siblings('.co-title').html();
      let currentDetails = jQuery(element).siblings('.co-details').html();

      // Create The From Wrapper
      let formWrapper = document.createElement('div');
      formWrapper.setAttribute('class', 'profile-co-block__edit-dropdown co-offer-update');

      // Create The Form Element
      let form = document.createElement("form");
      form.setAttribute('id', `__updateOffer-co-${co_id}`);
      form.setAttribute('class', '__updateOffer co-ind-form');
      form.setAttribute('name', '__updateOffer');
      form.setAttribute('action', '');


      // Create Hidden Input for co_id
      let coId = document.createElement('input');
      coId.setAttribute('type', 'hidden');
      coId.setAttribute('name', 'co_id');
      coId.setAttribute('value', co_id);

      // Create Hidden Input for co_author_id
      let coAuthorId = document.createElement('input');
      coAuthorId.setAttribute('type', 'hidden');
      coAuthorId.setAttribute('name', 'co_author_id');
      coAuthorId.setAttribute('value', co_author_id);

      // Create Hidden Input for Offer Title
      let coTitle = document.createElement('input');
      coTitle.setAttribute('class', 'form-input-1234');
      coTitle.setAttribute('type', 'text');
      coTitle.setAttribute('name', 'co_title');
      coTitle.setAttribute('value', currentTitle);
      coTitle.setAttribute('required', true);
      coTitle.setAttribute('placeholder', 'Offer title');
      

      // Create Hidden Input for Offer Details
      let coDetails = document.createElement('input');
      coDetails.setAttribute('class', 'form-input-1234');
      coDetails.setAttribute('type', 'textarea');
      coDetails.setAttribute('name', 'co_details');
      coDetails.setAttribute('value', currentDetails);
      coDetails.setAttribute('required', true);
      coDetails.setAttribute('placeholder', 'Offer description');

      // create a submit button 
      var s = document.createElement("input");
      s.setAttribute("type", "submit");
      s.setAttribute("value", "Submit");

      form.appendChild(coId);
      form.appendChild(coAuthorId);
      form.appendChild(coTitle);
      form.appendChild(coDetails);
      form.appendChild(s);

      formWrapper.appendChild(form);
      jQuery(element).parent().parent().append(formWrapper);

      jQuery('.__updateOffer').on('submit', function(e) {
        console.log(e);
        e.preventDefault();
        let form = jQuery(e.currentTarget);

        var __updateOfferFormData = {};

        jQuery.each(form.serializeArray(), function(i, field) {
          __updateOfferFormData[field.name] = field.value;
        });
        console.log(__updateOfferFormData);
        ajaxLoading();
        jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: myAjax.ajaxurl,
          data: {
            action: 'update_coffer',...__updateOfferFormData
          },
          success: function(response) {
            if (response.type === 'success') {
              ajaxSuccess();
              setTimeout(function() {
                console.log('succeed')
                location.reload();
              }, 1000);
            } else {
              console.log('Request Not Succeed');
            }
          }
        });
      });
    }

    // Function for destroy other edit forms if opened
    function destroyOfferUpdateForm(elements) {
      jQuery(elements).each(function(i, element) {
        jQuery(element).data('editable', false);
        jQuery(element).parent().siblings('.co-offer-update').remove();
      });
    }

    // Listen to "Get in Touch" button's click and generate send message form
    __sendMessage.each(function(i, btn) {
      jQuery(btn).click(function(e) {
        destroySendMessageForm(__sendMessage);
        e.target.style.display = 'none';
        generateMessageForm(e.target);
      });
    });

    // Generate send message form when a user click on the "Get in Touch" button
    function generateMessageForm(element) {
      let post_id = jQuery(element).data('post-id');
      let sender_id = jQuery(element).data('sender-id');
      let recipient_id = jQuery(element).data('recipient-id');

      let formWrapper = document.createElement('div');
      formWrapper.setAttribute('class', 'profile-co-block__edit-dropdown');


      // Create The Form Element
      let form = document.createElement("form");
      form.setAttribute('id', `__sendMessage-co-${post_id}`);
      form.setAttribute('class', '__sendMessage co-ind-form');
      form.setAttribute('action', '');

      let postId = document.createElement('input');
      postId.setAttribute('type', 'hidden');
      postId.setAttribute('name', 'post_id');
      postId.setAttribute('value', post_id);

      let postType = document.createElement('input');
      postType.setAttribute('type', 'hidden');
      postType.setAttribute('name', 'post_type');
      postType.setAttribute('value', 'offer');

      let senderId = document.createElement('input');
      senderId.setAttribute('type', 'hidden');
      senderId.setAttribute('name', 'sender_id');
      senderId.setAttribute('value', sender_id);

      let recipientId = document.createElement('input');
      recipientId.setAttribute('type', 'hidden');
      recipientId.setAttribute('name', 'recipient_id');
      recipientId.setAttribute('value', recipient_id);

      // Create Hidden Input for co_id
      let reason = document.createElement('input');
      reason.setAttribute('class', 'form-input-1234');
      reason.setAttribute('type', 'text');
      reason.setAttribute('name', 'reason_for_connection');
      reason.setAttribute('placeholder', 'Why do you want to connect?');
      reason.setAttribute('required', true);

      // Create Hidden Input for co_author_id
      let message = document.createElement('input');
      message.setAttribute('class', 'form-input-1234');
      message.setAttribute('type', 'text');
      message.setAttribute('name', 'message');
      message.setAttribute('placeholder', 'Write Your Message');
      message.setAttribute('required', true);

      var s = document.createElement("input");
      s.setAttribute("type", "submit");
      s.setAttribute("value", "Update");

      form.appendChild(postId);
      form.appendChild(postType);
      form.appendChild(senderId);
      form.appendChild(recipientId);
      form.appendChild(reason);
      form.appendChild(message);
      form.appendChild(s);

      formWrapper.appendChild(form);
      jQuery(element).parent().append(formWrapper);

      jQuery('.__sendMessage').on('submit', function(e) {
        e.preventDefault();
        let form = jQuery(e.currentTarget);
        console.log(form)

        var __messageFormData = {};

        jQuery.each(form.serializeArray(), function(i, field) {
          __messageFormData[field.name] = field.value;
        });
        console.log(__messageFormData);
        ajaxLoading();
        jQuery.ajax({
          type: 'POST',
          dataType: 'json',
          url: myAjax.ajaxurl,
          data: {
            action: 'send_request',
            ...__messageFormData
          },
          success: function(response) {
            console.log(response);
            if (response.type === 'success') {
              ajaxSuccess();
              setTimeout(function() {
                console.log('succeed')
                location.reload();
              }, 1000);
            } else {
              console.log('Request Not Succeed')
            }
          }
        });
      });
    }

    // Function for destroy other message forms if opened
    function destroySendMessageForm(elements) {
      jQuery(elements).each(function(i, element) {
        jQuery(element).css('display', 'block');
        jQuery(element).siblings('.profile-co-block__edit-dropdown').remove();
      });
    }

    // Loading animation when a request send
    function ajaxLoading() {
      var loadingOverlay = document.createElement('div');
      loadingOverlay.setAttribute('class', 'loading-overlay');

      let loadDiv = document.createElement('div');
      loadDiv.setAttribute('class', 'spinner')

      for (let i = 0; i < 8; i++) {
        let spinElm = document.createElement('div')
        loadDiv.append(spinElm);
      }

      jQuery(loadingOverlay).append(loadDiv);
      jQuery('.landing.membership-default').append(loadingOverlay);
      jQuery('.loading-overlay').addClass('load');
    }

    // Form validate function
    function validate(form_name, field_name, message) {
      let field_value = document.forms[form_name][field_name].value;
      if(field_value == " " || field_value.length < 3) {
        alert(message)
      }
    }

    // Success animation when a request succeed
    function ajaxSuccess() {
      jQuery('.spinner').remove();

      let success = document.createElement('div');
      success.setAttribute('class', 'success');

      let inner = document.createElement('div');
      inner.setAttribute('class', 'dct-icon dct-success animate');

      let content_1 = document.createElement('span');
      content_1.setAttribute('class', 'dct-line dct-tip animateSuccessTip');

      let content_2 = document.createElement('span');
      content_2.setAttribute('class', 'dct-line dct-long animateSuccessLong');

      let content_3 = document.createElement('div');
      content_3.setAttribute('class', 'dct-placeholder');

      let content_4 = document.createElement('div');
      content_4.setAttribute('class', 'dct-fix');

      inner.append(content_1);
      inner.append(content_2);
      inner.append(content_3);
      inner.append(content_4);
      success.append(inner);

      jQuery('.loading-overlay').append(success);

      jQuery(".dct-success").addClass("hide");
      setTimeout(function() {
        jQuery(".dct-success").removeClass("hide");
      }, 10);
    }

    function destroyPopup() {
      __popup.css('display', 'none');
    }

  }());
  console.log('Updated')
</script>

<style>
  .add_new_offer-2345 {
    display: none;
  }

  .profile-co-block__edit-dropdown {
    margin-top: 10px;
  }

  .form-input-1234 {
    margin-right: 10px;
  }

  .popup {
    display: none;
    position: fixed;
    z-index: 1;
    padding-top: 100px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(0, 0, 0);
    background-color: rgba(0, 0, 0, 0.4);
  }

  .popup-content {
    background-color: var(--lightblue);
    margin: auto;
    padding: 20px;
    border: 1px solid white;
    width: 60%;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
  }

  .popup-close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    position: absolute;
    top: 0;
    right: 10px;
    color: white;
  }

  .popup-close:hover,
  .popup-close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }

  .loading-overlay {
    position: fixed;
    top: 0;
    width: 100%;
    height: 100vh;
    background: #fff;
    display: none;
  }

  .loading-overlay.load {
    display: block;
    animation: fade-in 1s cubic-bezier(0.5, 0, 0.5, 1);
  }

  .spinner {
    display: inline-block;
    width: 80px;
    height: 80px;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -100%);
  }

  .spinner div {
    animation: spine 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    transform-origin: 40px 40px;
  }

  .spinner div:after {
    content: " ";
    display: block;
    position: absolute;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: rgb(31, 149, 255);
    margin: -4px 0 0 -4px;
  }

  .spinner div:nth-child(1) {
    animation-delay: -0.036s;
  }

  .spinner div:nth-child(1):after {
    top: 63px;
    left: 63px;
  }

  .spinner div:nth-child(2) {
    animation-delay: -0.072s;
  }

  .spinner div:nth-child(2):after {
    top: 68px;
    left: 56px;
  }

  .spinner div:nth-child(3) {
    animation-delay: -0.108s;
  }

  .spinner div:nth-child(3):after {
    top: 71px;
    left: 48px;
  }

  .spinner div:nth-child(4) {
    animation-delay: -0.144s;
  }

  .spinner div:nth-child(4):after {
    top: 72px;
    left: 40px;
  }

  .spinner div:nth-child(5) {
    animation-delay: -0.18s;
  }

  .spinner div:nth-child(5):after {
    top: 71px;
    left: 32px;
  }

  .spinner div:nth-child(6) {
    animation-delay: -0.216s;
  }

  .spinner div:nth-child(6):after {
    top: 68px;
    left: 24px;
  }

  .spinner div:nth-child(7) {
    animation-delay: -0.252s;
  }

  .spinner div:nth-child(7):after {
    top: 63px;
    left: 17px;
  }

  .spinner div:nth-child(8) {
    animation-delay: -0.288s;
  }

  .spinner div:nth-child(8):after {
    top: 56px;
    left: 12px;
  }

  @keyframes spine {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  @keyframes fade-in {
    0% {
      opacity: 0;
    }

    100% {
      opacity: 1;
    }
  }

  .success {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -100%);
  }

  .hide {
    display: none;
  }

  .dct-icon {
    width: 80px;
    height: 80px;
    border: 4px solid gray;
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    margin: 20px auto;
    padding: 0;
    position: relative;
    box-sizing: content-box;
  }

  .dct-icon.dct-success {
    border-color: rgb(31, 149, 255);
  }

  .dct-icon.dct-success::before,
  .dct-icon.dct-success::after {
    content: '';
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    position: absolute;
    width: 60px;
    height: 120px;
    background: white;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .dct-icon.dct-success::before {
    -webkit-border-radius: 120px 0 0 120px;
    border-radius: 120px 0 0 120px;
    top: -7px;
    left: -33px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 60px 60px;
    transform-origin: 60px 60px;
  }

  .dct-icon.dct-success::after {
    -webkit-border-radius: 0 120px 120px 0;
    border-radius: 0 120px 120px 0;
    top: -11px;
    left: 30px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
    -webkit-transform-origin: 0px 60px;
    transform-origin: 0px 60px;
  }

  .dct-icon.sa-success .dct-placeholder {
    width: 80px;
    height: 80px;
    border: 4px solid rgba(76, 175, 80, .5);
    -webkit-border-radius: 40px;
    border-radius: 40px;
    border-radius: 50%;
    box-sizing: content-box;
    position: absolute;
    left: -4px;
    top: -4px;
    z-index: 2;
  }

  .dct-icon.dct-success .dct-fix {
    width: 5px;
    height: 90px;
    background-color: white;
    position: absolute;
    left: 28px;
    top: 8px;
    z-index: 1;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  .dct-icon.dct-success.animate::after {
    -webkit-animation: rotatePlaceholder 4.25s ease-in;
    animation: rotatePlaceholder 4.25s ease-in;
  }

  .dct-icon.dct-success {
    border-color: transparent\9;
  }

  .dct-icon.dct-success .dct-line.dct-tip {
    -ms-transform: rotate(45deg) \9;
  }

  .dct-icon.dct-success .dct-line.dct-long {
    -ms-transform: rotate(-45deg) \9;
  }

  .animateSuccessTip {
    -webkit-animation: animateSuccessTip 0.75s;
    animation: animateSuccessTip 0.75s;
  }

  .animateSuccessLong {
    -webkit-animation: animateSuccessLong 0.75s;
    animation: animateSuccessLong 0.75s;
  }

  @-webkit-keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }

    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }

    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }

    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }

  @-webkit-keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }

    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }

    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }

    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }

    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }

  @keyframes animateSuccessTip {
    0% {
      width: 0;
      left: 1px;
      top: 19px;
    }

    54% {
      width: 0;
      left: 1px;
      top: 19px;
    }

    70% {
      width: 50px;
      left: -8px;
      top: 37px;
    }

    84% {
      width: 17px;
      left: 21px;
      top: 48px;
    }

    100% {
      width: 25px;
      left: 14px;
      top: 45px;
    }
  }

  @keyframes animateSuccessLong {
    0% {
      width: 0;
      right: 46px;
      top: 54px;
    }

    65% {
      width: 0;
      right: 46px;
      top: 54px;
    }

    84% {
      width: 55px;
      right: 0px;
      top: 35px;
    }

    100% {
      width: 47px;
      right: 8px;
      top: 38px;
    }
  }

  .dct-icon.dct-success .dct-line {
    height: 5px;
    background-color: rgb(31, 149, 255);
    display: block;
    border-radius: 2px;
    position: absolute;
    z-index: 2;
  }

  .dct-icon.dct-success .dct-line.dct-tip {
    width: 25px;
    left: 14px;
    top: 46px;
    -webkit-transform: rotate(45deg);
    transform: rotate(45deg);
  }

  .dct-icon.dct-success .dct-line.dct-long {
    width: 47px;
    right: 8px;
    top: 38px;
    -webkit-transform: rotate(-45deg);
    transform: rotate(-45deg);
  }

  @-webkit-keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }

    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }

    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }

    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }

  @keyframes rotatePlaceholder {
    0% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }

    5% {
      transform: rotate(-45deg);
      -webkit-transform: rotate(-45deg);
    }

    12% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }

    100% {
      transform: rotate(-405deg);
      -webkit-transform: rotate(-405deg);
    }
  }
</style>