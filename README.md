## Laboratory Activity 2 — RBAC

### Project Title
**Water Seeker — Water Access and Scheduling Management System**

### Project Description
Water Seeker is a web-based application designed to help manage water sources, water access requests, and water scheduling. It provides separate access for administrators and community users to ensure that users can only access functions permitted for their roles.

### Selected Middleware Approach
**Dynamic Role Middleware (Option A)**

The project uses custom middleware to dynamically check the authenticated user's role before allowing access to protected routes.

### Role and Permission Table

| Role | Permissions |
|---|---|
| Admin | Access the admin dashboard, manage water sources, manage access requests and approvals, manage schedules, view access records, manage users, and generate reports. |
| Community User | Access the community dashboard, view available water sources and schedules, and submit water access requests. |
| Guest | Access the login and registration pages only. Cannot access protected dashboards or management functions. |

### Middleware Implementation

- **Middleware class:** `RoleMiddleware`
- **Middleware alias:** `role`
- **Admin protection:** `role:admin`
- **Community User protection:** `role:community_user`

The middleware is registered in `bootstrap/app.php` using the `role` alias.

**Protected Routes and Actions:**
- Admin Dashboard
- Water Source Management (Create, Read, Update, Delete)
- Access Request Management
- Request Approvals
- Schedule Management
- Access Records
- User Management
- Reports
- Community User Dashboard and permitted community functions

### How the Middleware Works

The custom RoleMiddleware checks whether the user is authenticated before allowing access to protected routes. It retrieves the authenticated user's assigned role and compares it with the role required by the route. If the user's role matches the required role, the request is allowed to continue. If the role does not match, the system denies access and returns an unauthorized response. This prevents users from accessing functions that are not permitted for their accounts.

### RBAC Browser Testing Evidence

The following screenshots document the RBAC browser testing results.

1. **Admin Access:** [01-admin-allowed.png](evidence/01-admin-allowed.png)
2. **Community User Access:** [02-other-role-allowed.png](evidence/02-other-role-allowed.png)
3. **Unauthorized Role Access:** [03-role-denied.png](evidence/03-role-denied.png)
4. **Guest Access Restriction:** [04-guest-blocked.png](evidence/04-guest-blocked.png)
5. **Restricted Action Denial:** [05-restricted-action-denied.png](evidence/05-restricted-action-denied.png)

### Reflection

One of the challenges in implementing RBAC was properly assigning roles and protecting the routes based on the user's account type. Testing different accounts was also important to ensure that each role could only access its permitted functions. Server-side authorization is necessary because hiding buttons or pages in the interface alone cannot prevent unauthorized users from accessing protected URLs directly. Using middleware provides an additional layer of security by checking permissions before processing requests. Through this activity, I learned how role-based access control helps protect web applications and their resources.