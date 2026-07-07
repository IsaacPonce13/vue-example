<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import {
    House,
    LayoutGrid,
    Users,
    KeyRound,
    SquareLibrary,
} from 'lucide-vue-next';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard, modulos } from '@/routes';
import type { NavItem } from '@/types';

const page = usePage();
const auth = computed(() => page.props.auth || {});

const mainNavItems: NavItem[] = [
    {
        title: 'Inicio',
        href: dashboard(),
        icon: House,
    },
    {
        title: 'Modulos',
        href: modulos(),
        icon: LayoutGrid,
        permission: 'modulos',
    },
    {
        title: 'Usuarios',
        href: '/admin/usuarios',
        icon: Users,
        permission: 'usuarios',
    },
    {
        title: 'Roles y permisos',
        href: '/admin/roles',
        icon: KeyRound,
        permission: 'roles',
    },
    {
        title: 'Catalogos',
        href: '/admin/catalogos',
        icon: SquareLibrary,
        // permission: 'catalogos',
    },
];

const footerNavItems: NavItem[] = [
    // {
    //     title: 'Repository',
    //     href: 'https://github.com/laravel/vue-starter-kit',
    //     icon: FolderGit2,
    // },
    // {
    //     title: 'Documentation',
    //     href: 'https://laravel.com/docs/starter-kits#vue',
    //     icon: BookOpen,
    // },
];

const visibleMainNavItems = computed(() => {
    const userPermissions = auth.value.permissions;
    const permissions = Array.isArray(userPermissions) ? userPermissions : [];

    return mainNavItems.filter((item) => {
        return !item.permission || permissions.includes(item.permission);
    });
});
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="visibleMainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
