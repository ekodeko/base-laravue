<template>
  <AppLayout>
    <Head title="Create Contact" />

    <Card>
      <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="code">Code</label>
            <Input
              id="code"
              v-model="form.code"
              :error="form.errors.code"
            />
          </div>

          <div>
            <label for="name">Name</label>
            <Input
              id="name"
              v-model="form.name"
              :error="form.errors.name"
            />
          </div>

          <div>
            <label for="type">Type</label>
            <select
              id="type"
              v-model="form.type"
              class="form-select"
              :class="{ 'error': form.errors.type }"
            >
              <option value="">Select Type</option>
              <option value="customer">Customer</option>
              <option value="vendor">Vendor</option>
            </select>
          </div>

          <div>
            <label for="phone">Phone</label>
            <Input
              id="phone"
              v-model="form.phone"
              :error="form.errors.phone"
            />
          </div>

          <div>
            <label for="email">Email</label>
            <Input
              id="email"
              type="email"
              v-model="form.email"
              :error="form.errors.email"
            />
          </div>
        </div>

        <div>
          <label for="address">Address</label>
          <textarea
            id="address"
            v-model="form.address"
            rows="3"
            class="form-textarea w-full"
            :class="{ 'error': form.errors.address }"
          ></textarea>
        </div>

        <div class="flex justify-end space-x-2">
          <Button type="button" variant="secondary" :href="route('contacts.index')">
            Cancel
          </Button>
          <Button type="submit" :disabled="form.processing">
            Create Contact
          </Button>
        </div>
      </form>
    </Card>
  </AppLayout>
</template>
