<div class="type-small profile-co-block__outer">
  <div class="grid">
    <div class="grid-item">
      <h1>Available Community Offers</h1>
    </div>
    <div class="grid-item">

      <!-- Available Community Offers (non-logged in user) -->
      <div class="profile-co-block">
        <h1>Offer Title</h1>
        <p>Offer description, a short paragraph on what exactly the offer entails and who to contact and how to take the offer up.</p>
        <button>Get in Touch</button>
      </div>

      <!-- Available Community Offers (logged in user) -->
      <div class="profile-co-block">
        <div class="profile-co-block__title">
          <h1>Offer Title</h1>
          <!-- Delete offer button -->
          <button class="delete">Delete</button>

          <div class="profile-co-block__delete-confirm">
            <p>Are you sure you'd like to delete the Community Offer?</p>
            <button>Yes, delete the offer</button>
            <button>No, return to my offers</button>
          </div>
        </div>
        <p>Offer description, a short paragraph on what exactly the offer entails and who to contact and how to take the offer up.</p>
        <button>Get in Touch</button>

        <!-- Interactive buttons -->
        <button class="edit">Edit</button>
        <button class="profile-co-block__toggle">Enable</button>

        <!-- Edit Dropdown Form: displays once 'Edit' button is pressed -->
        <div class="profile-co-block__edit-dropdown">
          <form action="">
            <input type="text" name="title" id="" placeholder="Offer title">
            <input type="textarea" name="description" id="" placeholder="Offer description">
            <input type="submit" value="Submit">
          </form>
        </div>
      </div>
    </div>

    <!-- Submit a New Offer -->
    <div class="grid-item">
      <h1>Submit a new offer</h1>
    </div>

    <div class="grid-item">
      <p>Use the button below to send us the details of your offer</p>
      <button>Submit a Community Offer</button>

      <div class="profile-co-block__submit">
        <form action="">
          <input type="text" name="title" id="" placeholder="Offer Title">
          <input type="text" name="description" id="" placeholder="Offer Description">
          <input type="submit" value="Submit">
        </form>
      </div>
    </div>


  </div>
</div>