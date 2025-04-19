<template>
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 transition hover:shadow-md">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ contact.name }}</h2>
      
      <p class="text-sm text-gray-600"><span class="font-medium">Email:</span> {{ contact.email }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Phone:</span> {{ contact.phone }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Company:</span> {{ contact.company }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Country:</span> {{ contact.country }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Flag:</span> {{ contact.country_flag }}</p>
  
      <button
        @click="deleteContact"
        class="mt-4 inline-block text-sm bg-red-100 text-red-600 font-medium px-4 py-2 rounded hover:bg-red-200 transition"
      >
        Delete
      </button>
    </div>
  </template>
  
  
  <script>
  export default {
    props: ['contact'],
    methods: {
      deleteContact() {
        axios.delete(`/contacts/${this.contact.id}`).then(() => {
          this.$emit('contact-deleted');
        });
      },
    },
  };
  </script>
  