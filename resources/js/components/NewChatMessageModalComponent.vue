<template>
  <div>
    <div
      class="modal fade"
      id="newMessageModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="newMessageModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newMessageModalLabel">New Message</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <h5>Find users:</h5>
            <div>
              <input
                type="text"
                v-model="queryParameter"
                name="findUserByNameOrEmail"
                placeholder="Find a user by name or email"
                autofocus
              />
              <button class="btn btn-info" @click="searchUsersFromDb()">
                Search
              </button>

              <validation-errors :errors="searchUserValidationErrors" v-if="searchUserValidationErrors"></validation-errors>
            </div>

            <div class="table-responsive new-chat-modal-found-users-table">
              <table class="table table-sm table-hover">
                <thead>
                  <tr>
                    <th scope="col">Select</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="foundUser in foundUsers" :key="foundUser.id">
                    <td>
                      <input
                        type="checkbox"
                        id="checkbox"
                        @change="toggleUserFromSelectedUsers(foundUser)"
                        v-model="foundUser.selected"
                      />
                    </td>
                    <td>{{ foundUser.name }}</td>
                    <td>{{ foundUser.email }}</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <hr />

            <h5>Selected Users:</h5>
            <div>
              <span
                v-for="selectedUser in selectedUsers"
                :key="selectedUser.id"
                class="new-chat-modal-selected-user"
              >
                {{ selectedUser.email }}
                <span
                  class="badge badge-danger badge-remove-selected-user"
                  @click="removeSelectedUser(selectedUser)"
                  >X</span
                >
              </span>
            </div>

            <hr />
            <div class="">
              <label for="email" class="">Chat Name:</label>

              <span class="">
                <input
                  id="chatName"
                  type="text"
                  name="chatName"
                  v-model="chatName"
                  size="50"
                  placeholder="The name of the Chat room (Optional)"
                />
              </span>
            </div>

            <validation-errors :errors="storeChatRoomValidationErrors" v-if="storeChatRoomValidationErrors"></validation-errors>
          </div>

          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-primary"
              @click="storeChatRoom()"
            >
              Chat
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    errors: null,
    searchUserValidationErrors: null,
    queryParameter: "",
    foundUsers: [],
    chatName: "",
    selectedUsers: [],
    storeChatRoomValidationErrors: null,
  }),
  watch: {
    selectedUsers: function() {
      this.chatName = Array.prototype.map
        .call(this.selectedUsers, (u) => u.name)
        .join(", ") //Note: generate dynamic name based on users name separated by comma
        .substring(0, 55); //Note: limit generated name to 55 symbols because of backend max-length validation
    }
  },
  methods: {
    searchUsersFromDb() {
      this.searchUserValidationErrors = null;
      axios
        .get(`/api/users/new-chat-room-search?query=${this.queryParameter}`)
        .then((response) => {
          this.foundUsers = response.data;

          this.foundUsers.forEach((newFoundUser) => {
            let foundUser = this.selectedUsers.find(
              (u) => u.id == newFoundUser.id
            );
            if (foundUser === undefined) {
              this.$set(newFoundUser, "selected", false);
            } else {
              this.$set(newFoundUser, "selected", foundUser.selected);
            }
          });
        })
        .catch((e) => {
          if (e.response.status == 422) {
            this.searchUserValidationErrors = e.response.data.errors;
          }
        });
    },
    storeChatRoom() {
      let selectedUsersId = Array.prototype.map.call(
        this.selectedUsers,
        (u) => u.id
      );

      axios
        .post(`/api/chat-rooms`, {
          name: this.chatName,
          selected_users_id: selectedUsersId,
        })
        .then((response) => {
          if (response.status == 201) {
            window.location = response.data._redirect_url;
          }
        })
        .catch((e) => {
          if (e.response.status == 422) {
            this.storeChatRoomValidationErrors = e.response.data.errors;
          }
        });
    },
    toggleUserFromSelectedUsers(user) {
      if (user.selected == true) {
        this.selectedUsers.push(user);
      } else {
        this.__removeUserFromSelectedUsers(user);
      }
    },
    removeSelectedUser(user) {
      this.__removeUserFromSelectedUsers(user);
      user.selected = false;

      let foundUser = this.foundUsers.find((u) => u.id == user.id);
      if (foundUser != undefined) {
        foundUser.selected = false
      }
    },
    __removeUserFromSelectedUsers(user) {
      let userIndex = this.selectedUsers.findIndex((u) => u.id == user.id);
      if (userIndex != -1) {
        this.selectedUsers.splice(userIndex, 1);
      }
    },
  },
};
</script>
