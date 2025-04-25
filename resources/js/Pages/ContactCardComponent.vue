<template>
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 transition hover:shadow-md">
      <h2 class="text-lg font-semibold text-gray-800 mb-2">{{ contact.name }}</h2>
  
      <p class="text-sm text-gray-600"><span class="font-medium">Email:</span> {{ contact.email }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Phone:</span> {{ contact.phone }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Company:</span> {{ contact.company }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Country:</span> {{ contact.country }}</p>
      <p class="text-sm text-gray-600"><span class="font-medium">Flag:</span>
        <img :src="contact.country_flag" alt="Country Flag" class="inline-block w-6 h-4">
      </p>
  
      <button
        @click="editContact"
        class="mt-4 inline-block text-sm bg-blue-100 text-blue-600 font-medium px-4 py-2 rounded hover:bg-blue-200 transition mr-2"
      >
        Edit
      </button>
  
      <button
        @click="deleteContact"
        class="mt-4 inline-block text-sm bg-red-100 text-red-600 font-medium px-4 py-2 rounded hover:bg-red-200 transition"
      >
        Delete
      </button>
  
      <!-- Modal for editing contact -->
      <div v-if="isEditing" class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
          <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
          </div>
          <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
          <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
              <div class="mt-3 text-center sm:mt-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Contact</h3>
                <div class="mt-2">
                  <form @submit.prevent="updateContact" class="space-y-5">
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Name</label>
                      <input
                        v-model="editedContact.name"
                        type="text"
                        placeholder="John Doe"
                        required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition"
                      />
                    </div>
  
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Email</label>
                      <input
                        v-model="editedContact.email"
                        type="email"
                        placeholder="john@example.com"
                        required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition"
                      />
                    </div>
  
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Phone</label>
                      <input
                        v-model="editedContact.phone"
                        type="text"
                        placeholder="+229 00 00 00 00"
                        required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition"
                      />
                    </div>
  
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Company</label>
                      <input
                        v-model="editedContact.company"
                        type="text"
                        placeholder="Elyna Market"
                        required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition"
                      />
                    </div>
  
                    <div>
                      <label class="block text-sm font-medium text-gray-700">Country</label>
                      <select
                        v-model="editedContact.country"
                        @change="setCountryFlag"
                        required
                        class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-300 transition"
                      >
                        <option value="" disabled>Select a country</option>
                        <option
                          v-for="country in countries"
                          :key="country.name.common"
                          :value="country.name.common"
                        >
                          {{ country.name.common }}
                        </option>
                      </select>
                    </div>
  
                    <div class="pt-4">
                      <button
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition-colors duration-200"
                      >
                        Update Contact
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="mt-5 sm:mt-6">
              <button @click="cancelEdit" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:text-sm">Cancel</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
import { onMounted, ref } from 'vue';
  
  export default {
    props: {
      contact: {
        type: Object,
        required: true
      }
    },
    setup(props) {
      const isEditing = ref(false);
      const editedContact = ref({ ...props.contact });
      const countries = ref([]);
  
      const editContact = () => {
        isEditing.value = true;
      };
  
      const updateContact = () => {
        axios.put(`/contacts/${props.contact.id}`, editedContact.value)
          .then(() => {
            props.contact = { ...editedContact.value };
            isEditing.value = false;
            alert('Contact updated successfully!');
          })
          .catch(error => {
            console.error('Error updating contact:', error);
          });
      };
  
      const deleteContact = () => {
        axios.delete(`/contacts/${props.contact.id}`)
          .then(() => {
            alert('Contact deleted successfully!');
            window.location.reload(); // Recharge la page pour mettre à jour la liste des contacts
          })
          .catch(error => {
            console.error('Error deleting contact:', error);
          });
      };
  
      const cancelEdit = () => {
        isEditing.value = false;
        editedContact.value = { ...props.contact };
      };
  
      const fetchCountries = () => {
        axios.get('https://restcountries.com/v3.1/all')
          .then(response => {
            countries.value = response.data;
          })
          .catch(error => {
            console.error('Error fetching countries:', error);
          });
      };
  
      const setCountryFlag = () => {
        const selectedCountry = countries.value.find(
          country => country.name.common === editedContact.value.country
        );
        if (selectedCountry?.flags?.png) {
          editedContact.value.country_flag = selectedCountry.flags.png;
        } else {
          editedContact.value.country_flag = null;
        }
      };
  
      onMounted(() => {
        fetchCountries();
      });
  
      return {
        isEditing,
        editedContact,
        countries,
        editContact,
        updateContact,
        deleteContact,
        cancelEdit,
        setCountryFlag
      };
    }
  };
  </script>
  
  <style scoped>
  /* Ajoutez vos styles ici si nécessaire */
  </style>
  