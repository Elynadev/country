<template>
    <form @submit.prevent="submit" class="bg-gray-100 p-4 rounded">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input v-model="form.name" placeholder="Nom" required />
        <input v-model="form.email" placeholder="Email" type="email" required />
        <input v-model="form.phone" placeholder="Téléphone" required />
        <input v-model="form.company" placeholder="Entreprise" />
        <select v-model="form.country" required>
          <option v-for="country in countries" :value="country.name" :key="country.name">
            {{ country.name }}
          </option>
        </select>
      </div>
      <button class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Ajouter</button>
    </form>
  </template>
  
  <script setup>
  import { ref, onMounted, watch } from 'vue'
  import axios from 'axios'
  
  const emit = defineEmits(['contact-added'])
  
  const form = ref({
    name: '',
    email: '',
    phone: '',
    company: '',
    country: '',
    country_flag: ''
  })
  
  const countries = ref([])
  
  onMounted(async () => {
    const res = await axios.get('https://restcountries.com/v3.1/all')
    countries.value = res.data.map(c => ({
      name: c.name.common,
      flag: c.flags?.png || c.flags?.svg
    }))
  })
  
  watch(() => form.value.country, (newVal) => {
    const selected = countries.value.find(c => c.name === newVal)
    form.value.country_flag = selected?.flag || ''
  })
  
  function submit() {
    axios.post('/contacts', form.value).then(() => {
      emit('contact-added')
      form.value = {
        name: '', email: '', phone: '', company: '', country: '', country_flag: ''
      }
    })
  }
  </script>
  