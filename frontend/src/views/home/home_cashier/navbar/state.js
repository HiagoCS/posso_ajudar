import {ref, computed} from 'vue';
export const collapsed = ref(false);

export const NAVBAR_WIDTH = 300
export const NAVBAR_WIDTH_COLLAPSED = 150
export const navbarWidth = computed(
    () => `${collapsed.value ? NAVBAR_WIDTH_COLLAPSED : NAVBAR_WIDTH}px`
)
export const teste = "HELLO WORLD"