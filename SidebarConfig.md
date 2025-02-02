1. **_# Sidebar Configuration Documentation
_**2. 
3. This documentation describes how to use the `SideBar::add()` method to create a custom sidebar configuration with multiple options, including sub-links, icons, visibility, permissions, and active routes.
4. 
5. ## Sidebar Configuration Example
6. 
7. ### Adding a Sidebar
8. 
9. The following example demonstrates how to add a "Product" on sidebar with its associated sub-links:
10. 
11. php
12. ```
13. SideBar::add('Product', Product::class) //$model is optional
14.     ->icon('fa-brands fa-product-hunt')
15.     ->route('') //optional
16.     ->title('Product')
17.     ->group('Purchase') // group under the 'Purchase' category # default is core
18.     ->hid_**e(true) 
19.     ->permission(true)
20.     ->activeOnRoutes('admin/products/mainSidebar')
21.     ->subLinks(
22.         SubLink::add('Add Product')
23.             ->icon('fa-solid fa-plus')
24.             ->route('/admin/products/create')
25.             ->hide(true)
26.             ->permission(true)
27.             ->activeOnRoutes('/products/other_route'),
28.         SubLink::add('List Products')
29.             ->icon('fa-solid fa-list')
30.             ->route('/admin/products')
31.             ->hide(true)
32.             ->permission(true)
33.             ->activeOnRoutes(['admin/products\other_list])
34.     );
35. ```
36. 
37. ### Breakdown of the Configuration
38. 
39. #### Adding Sidebar:
40. 
41. -   `SideBar::add('Product')`: This creates a new sidebar item titled "Product".
42. 
43. #### Sidebar Properties:
44. 
45. -   `->group('Purchase')`: Sets the sidebar item’s icon using Font Awesome. Here, it uses the "fa-product-hunt" icon.
46. -   `->icon('fa-brands fa-product-hunt')`: Sets the sidebar item’s icon using Font Awesome. Here, it uses the "fa-product-hunt" icon.
47. -   `->route('')`: Defines the route for the sidebar item. In this case, the route is left blank, which can be configured based on your needs.
48. -   `->title('Product')`: The title that appears on the sidebar. It is set as "Product".
49. -   `->hide(true)`: Specifies that the sidebar item is visible. Set to `true` to make it visible.
50. -   `->permission(true)`: Specifies that the sidebar item is available for users with permission. Set to `true` to allow access.
51. -   `->activeOnRoutes('admin/products/mainSidebar')`: Defines the route(s) where this sidebar item should be marked as active. In this case, it is active when the route matches `admin/products/mainSidebar`.
52. 
53. ### Sub Links
54. 
55. The sidebar item can have multiple sub-links. These sub-links are defined using the `subLinks()` method.
56. 
57. #### Add Product Sub-Link:
58. 
59. php
60. 
61. ```
62. SubLink::add('Add Product')
63.     ->icon('fa-solid fa-plus')
64.     ->route('/admin/products/route_create11')
65.     ->hide(true)
66.     ->permission(true)
67.     ->activeOnRoutes('/kaushala/products/active_on_create1')
68. ```
69. 
70. -   `SubLink::add('Add Product')`: Creates a sub-link titled "Add Product".
71. -   `->icon('fa-solid fa-plus')`: Sets the icon for the sub-link. In this case, it's a plus icon.
72. -   `->route('/admin/products/route_create11')`: Specifies the route for this sub-link.
73. -   `->hide(true)`: Makes the sub-link visible.
74. -   `->permission(true)`: Grants permission for the sub-link.
75. -   `->activeOnRoutes('/kaushala/products/active_on_create1')`: Marks the sub-link as active for the specified route.
76. 
77. #### List Products Sub-Link:
78. 
79. php
80. 
81. ```
82. SubLink::add('List Products')
83.     ->icon('fa-solid fa-list')
84.     ->route('/admin/products/route_create')
85.     ->hide(true)
86.     ->permission(true)
87.     ->activeOnRoutes(['hari/admin/products+a'])
88. ```
89. 
90. -   `SubLink::add('List Products')`: Creates another sub-link titled "List Products".
91. -   `->icon('fa-solid fa-list')`: Sets the icon for the sub-link as a list icon.
92. -   `->route('/admin/products/route_create')`: Specifies the route for the "List Products" sub-link.
93. -   `->hide(true)`: Ensures the sub-link is visible.
94. -   `->permission(true)`: Grants permission for the sub-link.
95. -   `->activeOnRoutes(['hari/admin/products+a'])`: Marks the sub-link as active for the specified route(s).
96. 
97. ## Method Details
98. 
99. ### `SideBar::add($name)`
100. 
101. -   **Description**: Adds a new sidebar item.
102. -   **Parameters**:
103.     -   `$name`: The title of the sidebar item (e.g., 'Product').
104. 
105. ### `->icon($icon)`
106. 
107. -   **Description**: Sets the icon for the sidebar item.
108. -   **Parameters**:
109.     -   `$icon`: The Font Awesome class for the icon (e.g., 'fa-brands fa-product-hunt').
110. 
111. ### `->route($route)`
112. 
113. -   **Description**: Defines the route for the sidebar item.
114. -   **Parameters**:
115.     -   `$route`: The route URL for the sidebar item (can be a string or a route name).
116. 
117. ### `->title($title)`
118. 
119. -   **Description**: Sets the title text that will be displayed for the sidebar item.
120. -   **Parameters**:
121.     -   `$title`: The title of the sidebar item (e.g., 'Product').
122. 
123. ### `->hide($hide)`
124. 
125. -   **Description**: Controls the hide of the sidebar item.
126. -   **Parameters**:
127.     -   `$hide`: `true` to make the item visible, `false` to hide it.
128. 
129. ### `->permission($permission)`
130. 
131. -   **Description**: Determines whether the sidebar item is accessible based on user permissions.
132. -   **Parameters**:
133.     -   `$permission`: `true` if the item is accessible, `false` if not.
134. 
135. ### `->activeOnRoutes($routes)`
136. 
137. -   **Description**: Defines the routes where the sidebar item will be marked as active.
138. -   **Parameters**:
139.     -   `$routes`: A string or an array of route names or URLs.
140. 
141. ### `subLinks($subLinks)`
142. 
143. -   **Description**: Adds sub-links to the sidebar item.
144. -   **Parameters**:
145.     -   `$subLinks`: An array of `SubLink` instances, each representing a sub-link.
146. 
147. ## SubLink Configuration
148. 
149. ### Example SubLink Method:
150. 
151. php
152. 
153. ```
154. SubLink::add('Link Name')
155.     ->icon('fa-solid fa-icon')
156.     ->route('/link/route')
157.     ->hide(true)
158.     ->permission(true)
159.     ->activeOnRoutes('/route/active_on_link');
160. ```
161. 
162. ### SubLink Method Details:
163. 
164. -   `SubLink::add($name)`: Adds a sub-link with the specified name.
165. -   `->icon($icon)`: Sets the icon for the sub-link.
166. -   `->route($route)`: Defines the route for the sub-link.
167. -   `->hide($hide)`: Controls the visibility of the sub-link.
168. -   `->permission($permission)`: Specifies whether the sub-link is available based on permissions.
169. -   `->activeOnRoutes($routes)`: Marks the sub-link as active for the given route(s).
170. 
171. ### Blade Code for Frontend here:
172. 
173. ```
174. @foreach(app('sidebar') as $key_1 => $group)
175.     @if($key_1 != 'core')
176.          <!-- Group Header -->
177.         <li class="nav-header">{{ $key_1 }}</li>
178.         // Handle other logic here
179.     @endif
180. 
181.     @foreach(app('sidebar')[$key_1] as $key => $main_link)
182.         @if( $main_link['hide'] && $main_link['permission'])
183.             // Handle main link logic here
184. 
185.             @if(count($main_link['sub_links']) > 0)
186.                 @foreach($main_link['sub_links'] as $key_sub_link => $sub_link)
187.                     @if($sub_link['hide'] && $sub_link['permission'])
188.                         // Handle sub-link logic here
189.                     @endif
190.                 @endforeach
191.             @endif
192.         @endif
193.     @endforeach
194. @endforeach
195. ```
196. ### JS Code for frontend
197. ```
198. const sidebar = app('sidebar'); // Assuming 'sidebar' is available in your app context
199. 
200. Object.keys(sidebar).forEach(key_1 => {
201.     if (key_1 !== 'core') {
202.             <!-- Group Header -->
203.         // Handle group logic here
204.     }
205. 
206.     sidebar[key_1].forEach(main_link => {
207.         if (main_link.hide && main_link.permission) {
208.             // Handle main link logic here
209. 
210.             if (main_link.sub_links && main_link.sub_links.length > 0) {
211.                 main_link.sub_links.forEach(sub_link => {
212.                     if (sub_link.hide && sub_link.permission) {
213.                         // Handle sub-link logic here
214.                     }
215.                 });
216.             }
217.         }
218.     });
219. });
220. 
221. ```
222. 
223. 
224. ```
225. 
226. 
227. This version includes more detailed descriptions and is structured for better readability.
228. Let me know if you need any further enhancements!
229. 
230. ```
231. 
232. ### Future Implementation Grouping like this. coming soon...
233. 
234. ```
235. SideBar::group('setting',function(){
236.              SideBar::add('User Management')
237.                  ->icon('fa-solid fa-users')
238.                  ->subLinks(
239.                      SubLink::add('Users', User::class)
240.                          ->icon('fa-solid fa-user ')
241.                          ->route('/admin/users'),
242.                      SubLink::add('Roles', Role::class)
243.                          ->icon('fa-solid fa-user ')
244.                          ->route('/admin/roles')
245.                  );
246.              SideBar::add('User Management')
247.                  ->icon('fa-solid fa-users')
248.                  ->subLinks(
249.                      SubLink::add('Users', User::class)
250.                          ->icon('fa-solid fa-user ')
251.                          ->route('/admin/users'),
252.                      SubLink::add('Roles', Role::class)
253.                          ->icon('fa-solid fa-user ')
254.                          ->route('/admin/roles')
255.                  );
256. });
257. ```**_
258. 
