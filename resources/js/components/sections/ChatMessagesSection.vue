<template>
  <div class="col-md-9 chat-message row">
    <div class="col-md-2"></div>
    <div class="col-md-10 message-applet">
      <div id="all-messages-section" class="all-messages">
        <div
          class="message-box"
          v-for="message in chatRoomMessages"
          :key="message.id"
        >
          <div v-if="message.user_id == authUserId">
            <div class="text-align-right">Me, {{ message.created_at }}</div>
            <div class="auth-user-message text-align-right">
              {{ message.value }}
            </div>
          </div>
          <div v-else>
            <div>{{ message.user_name }}, {{ message.created_at }}</div>
            <div class="other-users-message">{{ message.value }}</div>
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
    authUserId: {
      type: Number,
      required: true,
    },
  },
  data: () => ({
    newMessageText: "",
    validationErrors: null,
    chatRoomMessages: [],
  }),
  mounted() {
    this.getAllMessagesInThisChatRoom();
  },
  methods: {
    getAllMessagesInThisChatRoom() {
      axios
        .get(`/api/chat-rooms/${this.chatRoomId}/messages`)
        .then((response) => {
          this.chatRoomMessages = response.data;

          //Note: force the scrollbar of all messages in chat room to be always bottom
          let allMessagesSection = this.$el.querySelector("#all-messages-section");
          setTimeout(function () {
            allMessagesSection.scrollTop = allMessagesSection.scrollHeight;
          }, 1);
        });
    },
    storeMessage() {
      if(this.newMessageText.length < 1){ //Note: do not make request when the field is empty
        return;
      }

      this.validationErrors = null;

      axios
        .post(`/api/chat-rooms/${this.chatRoomId}/messages`, {
          value: this.newMessageText,
        })
        .then((response) => {
          this.newMessageText = "";
          this.getAllMessagesInThisChatRoom();
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