<template>
  <div class="col-md-9 row home-applet">
    <div class="text-center">
      <p class="hello-text">Hello, {{ userName }}</p>
      <p class="description-text">
        To start a new conversation click on New Message..
      </p>
    </div>
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