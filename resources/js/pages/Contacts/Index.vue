<template>
  <AppLayout>
    <Head title="Contacts" />

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-semibold">Contacts</h2>
      <Link href="/contacts/create" class="btn-primary">
        Create Contact
      </Link>
    </div>

    <Table
      :columns="columns"
      :items="contacts.data"
      :pagination="contacts"
    >
      <template #cell-type="{ item }">
        <span class="capitalize">{{ item.type }}</span>
      </template>

      <template #cell-actions="{ item }">
        <div class="flex space-x-2">
          <Link :href="`/contacts/${item.id}/edit`" class="btn-secondary btn-sm">
            Edit
          </Link>
          <Button
            variant="destructive"
            size="sm"
            @click="deleteContact(item.id)"
          >
            Delete
          </Button>
        </div>
      </template>
    </Table>
  </AppLayout>
</template>
