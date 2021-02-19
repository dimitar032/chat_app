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
      <li
        v-for="chatRoom in userChatRooms"
        :key="chatRoom.id"
        :class="{ active: chatRoom.id === openedChatRoomId }"
      >
        <a :href="'/chat-rooms/' + chatRoom.id">
        <div class="chat-room-list-name">
          {{ chatRoom.name }}
        </div>
        
        </a>
      </li>
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
  props: {
    authUserId: {
      type: Number,
      required: true,
    },
    openedChatRoomId: {
      type: Number,
      required: false,
    },
  },
  mounted() {
    axios
      .get(`/api/users/${this.authUserId}/chat-rooms`)
      .then((response) => {
        this.userChatRooms = response.data;
      })
  },
  data: () => ({
    userChatRooms: [],
  }),
};
</script>