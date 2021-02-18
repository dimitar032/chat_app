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

              <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
            </div>

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
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck1"
                      />
                      <label class="custom-control-label" for="customCheck1"></label>
                    </div>
                  </td>
                  <td>{{ foundUser.name }}</td>
                  <td>{{ foundUser.email }}</td>
                </tr>
              </tbody>
            </table>

            <hr />
            <div class="">
              <label for="email" class="">Chat Name:</label>

              <span class="">
                <input
                  id="chatName"
                  type="text"
                  name="chatName"
                  size="50"
                  placeholder="The name of the Chat room (Optional)"
                />
              </span>
            </div>

            <hr />

            <h4>Selected:</h4>
            <div>
              <span class="new-chat-modal-selected-user">
                user1@test.test
                <span class="badge badge-danger" @click="foo">X</span>
              </span>
            </div>
            <div>
              <span class="new-chat-modal-selected-user">
                user1@test.test
                <span class="badge badge-danger" @click="foo">X</span>
              </span>

              <span class="new-chat-modal-selected-user">
                user2@test.test
                <span class="badge badge-danger" @click="foo">X</span>
              </span>
              <span class="new-chat-modal-selected-user">
                user3@test.test
                <span class="badge badge-danger" @click="foo">X</span>
              </span>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-primary">Chat</button>
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
    validationErrors: null,
    queryParameter: "",
    foundUsers: [],
  }),
  methods: {
    searchUsersFromDb() {
      this.validationErrors = null;
      axios
        .get(`/api/users/new-chat-room-search?query=${this.queryParameter}`)
        .then((response) => {
          this.foundUsers = response.data;

          this.foundUsers.forEach((user) => {
            this.$set(user, "selected", false);
          });
        })
        .catch((e) => {
          if (e.response.status == 422) {
            this.validationErrors = e.response.data.errors;
          }
        });
    },
    foo() {
      console.log("hello from remove user");
    },
  },
};
</script>
