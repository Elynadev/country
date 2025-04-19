<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Liste des contacts</h1>
      <ContactFormComponent @contact-added="fetchContacts" />
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
        <ContactCardComponent
          v-for="contact in contacts"
          :key="contact.id"
          :contact="contact"
          @deleted="fetchContacts"
        />
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import ContactCardComponent from '@/Components/ContactCardComponent.vue'
  import ContactFormComponent from '@/Components/ContactFormComponent.vue'
  import { router } from '@inertiajs/vue3'
  import axios from 'axios'
  
  const props = defineProps({ contacts: Array })
  const contacts = ref([...props.contacts])
  
  function fetchContacts() {
    router.reload({ only: ['contacts'] })
  }
  </script>
  