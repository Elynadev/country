<template>
    <div class="bg-white p-4 shadow rounded">
      <div class="flex items-center gap-4">
        <img :src="contact.country_flag" alt="" class="w-10 h-10 object-contain" />
        <div>
          <h2 class="font-bold">{{ contact.name }}</h2>
          <p>{{ contact.email }} | {{ contact.phone }}</p>
          <p class="text-sm text-gray-500">{{ contact.company }} - {{ contact.country }}</p>
        </div>
      </div>
      <button @click="remove" class="text-red-500 mt-2">Supprimer</button>
    </div>
  </template>
  
  <script setup>
  const props = defineProps({ contact: Object })
  const emit = defineEmits(['deleted'])
  
  function remove() {
    if (confirm('Supprimer ce contact ?')) {
      axios.delete(`/contacts/${props.contact.id}`).then(() => emit('deleted'))
    }
  }
  </script>
  