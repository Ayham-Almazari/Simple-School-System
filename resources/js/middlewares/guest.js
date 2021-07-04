export default function guest({ next, store }) {
    if (store.getters["auth/token"]) {
        return next({ name: "home" });
    } else {
        return next();
    }
}
