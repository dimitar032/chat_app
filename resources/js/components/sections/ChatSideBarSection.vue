<template>
  <div class="col-md-3 chat-room">
    <div
      class="chat-room-new-room-button"
      data-toggle="modal"
      data-target="#newMessageModal"
    >
      New Message
    </div>
    <div class="space-between-new-message-and-first-user"></div>
    <ul class="chat-room-list">
      <li>User1</li>
      <li class="active">User2</li>
      <li>Group1</li>
      <li>Group2</li>
      <li>User3</li>
    </ul>

    <new-chat-message-modal-component></new-chat-message-modal-component>
  </div>
</template>

<script>
import NewChatMessageModalComponent from "../NewChatMessageModalComponent";

export default {
  components: {
    NewChatMessageModalComponent,
  },
};
</script>