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
                name="findUserByNameOrEmail"
                placeholder="Find a user by name or email"
                autofocus
              />
              <button type="submit" class="btn btn-info">Search</button>
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
                <tr>
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
                  <td>User1</td>
                  <td>user1@test.test</td>
                </tr>
                <tr>
                  <td>
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck2"
                      />
                      <label class="custom-control-label" for="customCheck2"></label>
                    </div>
                  </td>
                  <td>User2</td>
                  <td>user2@test.test</td>
                </tr>
                <tr>
                  <td>
                    <div class="custom-control custom-checkbox">
                      <input
                        type="checkbox"
                        class="custom-control-input"
                        id="customCheck3"
                      />
                      <label class="custom-control-label" for="customCheck3"></label>
                    </div>
                  </td>
                  <td>User2</td>
                  <td>user2@test.test</td>
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
export default {
  methods: {
    foo() {
      console.log("hello from remove user");
    },
  },
};
</script>
