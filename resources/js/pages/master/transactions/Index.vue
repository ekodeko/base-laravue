<template>
  <Head title="Transactions" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div>
        <Link href="/master/transactions/create">
          <Button>
            + Add Transaction
          </Button>
        </Link>

        <div class="space-y-4 mt-4">
          <!-- Toolbar -->
          <div class="flex items-center justify-between">
            <input v-model="search" type="text" placeholder="Filter data..."
              class="w-1/3 rounded-md border px-3 py-2 text-sm bg-background" />
          </div>
          <!-- Table -->
          <div class="border rounded-lg shadow-sm mt-4 space-y">
            <Table>
              <TableHeader>
                <TableRow>
                  <TableHead>Date</TableHead>
                  <TableHead>Number</TableHead>
                  <TableHead>Type</TableHead>
                  <TableHead>Description</TableHead>
                  <TableHead>Amount</TableHead>
                  <TableHead>Account</TableHead>
                  <TableHead>Category</TableHead>
                  <TableHead>Contact</TableHead>
                  <TableHead class="text-right">Action</TableHead>
                </TableRow>
              </TableHeader>
              <TableBody>
                <TableRow v-for="transaction in filteredData" :key="transaction.id">
                  <TableCell>{{ formatDate(transaction.date) }}</TableCell>
                  <TableCell class="font-medium">{{ transaction.number }}</TableCell>
                  <TableCell>
                    <span
                      :class="[
                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium',
                        transaction.type === 'income'
                          ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-600/20'
                          : 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-600/20'
                      ]"
                    >
                      {{ transaction.type }}
                    </span>
                  </TableCell>
                  <TableCell>{{ transaction.description }}</TableCell>
                  <TableCell class="text-right">{{ formatCurrency(transaction.amount) }}</TableCell>
                  <TableCell>{{ transaction.account?.name }}</TableCell>
                  <TableCell>{{ transaction.category?.name }}</TableCell>
                  <TableCell>{{ transaction.contact?.name }}</TableCell>
                  <TableCell class="text-right">
                    <DropdownMenu>
                      <DropdownMenuTrigger as-child>
                        <Button variant="ghost" size="icon">
                          <MoreHorizontal class="h-4 w-4" />
                        </Button>
                      </DropdownMenuTrigger>
                      <DropdownMenuContent align="end">
                        <DropdownMenuLabel>Actions</DropdownMenuLabel>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem as-child>
                          <Link :href="`/master/transactions/${transaction.id}/edit`">Edit</Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem as-child>
                          <Link method="delete" :href="`/master/transactions/${transaction.id}`" as="button"
                            class="w-full text-red-600">
                            Delete
                          </Link>
                        </DropdownMenuItem>
                      </DropdownMenuContent>
                    </DropdownMenu>
                  </TableCell>
                </TableRow>
              </TableBody>
            </Table>
          </div>
          <!-- Pagination -->
          <div class="mt-4">
            <PaginationWrapper :meta="meta" :links="links" />
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import PaginationWrapper from '@/components/PaginationWrapper.vue';
import Button from '@/components/ui/button/Button.vue';
import DropdownMenu from '@/components/ui/dropdown-menu/DropdownMenu.vue';
import DropdownMenuContent from '@/components/ui/dropdown-menu/DropdownMenuContent.vue';
import DropdownMenuItem from '@/components/ui/dropdown-menu/DropdownMenuItem.vue';
import DropdownMenuLabel from '@/components/ui/dropdown-menu/DropdownMenuLabel.vue';
import DropdownMenuSeparator from '@/components/ui/dropdown-menu/DropdownMenuSeparator.vue';
import DropdownMenuTrigger from '@/components/ui/dropdown-menu/DropdownMenuTrigger.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { formatDate } from '@/lib/format';

const props = defineProps({
  transactions: Object
})

const meta = props.transactions.meta
const links = props.transactions.links

const breadcrumbs = [
  {
    title: 'Transaction',
    href: '/master/transactions',
  },
];

const search = ref("")

// filtering sederhana
const filteredData = computed(() => {
  if (!search.value) return props.transactions.data
  return props.transactions.data.filter(row =>
    Object.values(row).some(v =>
      String(v).toLowerCase().includes(search.value.toLowerCase())
    )
  )
})

const formatCurrency = (amount) => {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR'
  }).format(amount)
}
</script>
