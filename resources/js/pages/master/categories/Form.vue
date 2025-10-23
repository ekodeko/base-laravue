<template>
  <Head :title="isEdit ? 'Edit Category' : 'Create Category'" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="max-w-lg mx-auto p-6 shadow rounded">
        <h1 class="text-xl font-bold mb-4">
          {{ isEdit ? 'Edit Category' : 'Create Category' }}
        </h1>

        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-sm font-medium">Parent Category</label>
            <select v-model="form.parent_id" class="w-full border rounded p-2">
              <option value="">-- None --</option>
              <option v-for="p in parents" :key="p.id" :value="p.id">
                {{ p.name }}
              </option>
            </select>
            <div v-if="form.errors.parent_id" class="text-red-500 text-sm">{{ form.errors.parent_id }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Code</label>
            <input v-model="form.code" type="text" class="w-full border rounded p-2" />
            <div v-if="form.errors.code" class="text-red-500 text-sm">{{ form.errors.code }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Name</label>
            <input v-model="form.name" type="text" class="w-full border rounded p-2" />
            <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-medium">Type</label>
            <select v-model="form.type" class="w-full border rounded p-2">
              <option value="">-- Select Type --</option>
              <option v-for="t in types" :key="t" :value="t">{{ t }}</option>
            </select>
            <div v-if="form.errors.type" class="text-red-500 text-sm">{{ form.errors.type }}</div>
          </div>

          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
              {{ isEdit ? 'Update' : 'Create' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  category: Object,
  parents: Array,
  types: Array
})

const form = useForm({
  parent_id: props.category?.parent_id || '',
  code: props.category?.code || '',
  name: props.category?.name || '',
  type: props.category?.type || ''
})

const isEdit = computed(() => !!props.category)

const submit = () => {
  if (isEdit.value) {
    form.put(`/master/categories/${props.category.id}`)
  } else {
    form.post('/master/categories')
  }
}

const breadcrumbs = [
  {
    title: 'Category',
    href: '/master/categories',
  },
  {
    title: isEdit.value ? 'Edit' : 'Add',
    href: '',
  },
];
</script>
