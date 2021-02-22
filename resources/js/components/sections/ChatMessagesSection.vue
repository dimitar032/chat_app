<template>
  <div class="col-md-9 chat-message row">
    <div class="col-md-2"></div>
    <div class="col-md-10 message-applet">
      <div class="all-messages">
        <div class="message-box">
          <div class="text-align-right">Me, 10:34</div>
          <div class="auth-user-message text-align-right">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
            eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
            ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
            aliquip ex ea commodo consequat. Duis aute irure dolor in
            reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
            pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
            culpa qui officia deserunt mollit anim id est laborum
          </div>
        </div>

        <div class="message-box">
          <div class="">User2, 10:35</div>
          <div class="other-users-message">Message 1</div>
        </div>

        <div class="message-box">
          <div class="text-align-right">Me, 10:36</div>
          <div class="auth-user-message text-align-right">Message 2</div>
        </div>

        <div class="message-box">
          <div class="">User2, 10:37</div>
          <div class="other-users-message">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eum culpa
            exercitationem nisi, sed saepe quas? Deleniti, debitis iure
            molestias saepe mollitia enim itaque excepturi culpa, sed
            consectetur exercitationem temporibus quam!
          </div>
        </div>
      </div>

      <div class="send-message-box">
        <input
          class="new-message-input"
          id="newMessage"
          type="text"
          v-model="newMessageText"
          name="newMessage"
          placeholder="Type a message"
          autofocus
        />
        <button @click="storeMessage()" class="btn btn-primary">Send</button>
      </div>

      <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  props: {
    chatRoomId: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    newMessageText: "",
    validationErrors: null,
  }),
  methods: {
    storeMessage() {
      this.validationErrors = null;

      axios
        .post(`/api/chat-rooms/${this.chatRoomId}/messages`, {
          value: this.newMessageText,
        })
        .then((response) => {
          this.newMessageText = "";
          console.log(response);
        })
        .catch((e) => {
          if (e.response.status == 422) {
            this.validationErrors = e.response.data.errors;
          }
        });
    },
  },
};
</script>