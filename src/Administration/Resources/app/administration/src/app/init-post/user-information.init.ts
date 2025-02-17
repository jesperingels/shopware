/**
 * @sw-package framework
 */

import { initializeUserNotifications } from 'src/app/store/notification.store';

// eslint-disable-next-line sw-deprecation-rules/private-feature-declarations
export default function initializeUserContext() {
    return new Promise<void>((resolve) => {
        const loginService = Shopware.Service('loginService');
        const userService = Shopware.Service('userService');

        // The user isn't logged in
        if (!loginService.isLoggedIn()) {
            // Remove existing login info from the locale storage
            loginService.logout();
            resolve();
            return;
        }

        userService
            .getUser()
            .then((response) => {
                // eslint-disable-next-line max-len
                // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access,@typescript-eslint/no-unsafe-assignment
                const data = response?.data;
                // eslint-disable-next-line @typescript-eslint/no-unsafe-member-access
                delete data.password;

                Shopware.Store.get('session').setCurrentUser(data as EntitySchema.user);
                initializeUserNotifications();
                resolve();
            })
            .catch(() => {
                // An error occurred which means the user isn't logged in so get rid of the information in local storage
                loginService.logout();
                resolve();
            });
    });
}
