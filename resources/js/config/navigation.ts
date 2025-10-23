import { defineComponent } from 'vue'
import { HomeIcon, UsersIcon, CogIcon } from '@heroicons/vue/24/outline'

export const navigation = [
  {
    name: 'Dashboard',
    href: '/dashboard',
    icon: HomeIcon
  },
  {
    name: 'Contacts',
    href: '/contacts',
    icon: UsersIcon
  },
  {
    name: 'Settings',
    href: '/settings',
    icon: CogIcon
  }
]
