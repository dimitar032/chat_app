<template>
  <div>
    <p>Hello, {{ userName }}</p>
    <p>To start a new conversation click on New Message..</p>
  </div>
</template>


<script>
export default {
  props: {
    userName: {
      type: String,
      required: true,
    },
  },
};
</script>