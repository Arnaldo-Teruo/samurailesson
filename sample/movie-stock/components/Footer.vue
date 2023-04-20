<template>
  <footer class="mt-5 py-4 bg-info text-white text-center">
    {{ copyright }}
  </footer>
</template>

<script>
export default {
  data() {
    return {
      copyright: process.env.copyright,
    }
  },
}
</script>
