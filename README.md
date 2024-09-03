# 🏠 Backend Project

## Overview
This backend project, meticulously architected with the Laravel framework, forms the nucleus of the application. It efficiently orchestrates data processing, business logic, and the provision of API endpoints. The backend is designed to seamlessly handle user authentication, facilitate the management of property listings, and support a suite of sophisticated functionalities tailored to meet both guest and registered user needs.

![Dashboard](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/welcome_dashboard.png)

## Features

### 🔒 User Authentication
- **Secure Registration and Login**: Employing robust security protocols, the system allows users to register and log in, ensuring that their credentials and personal information remain secure.
- **Role-based Access Control**: The backend enforces a strict role-based access control mechanism, which selectively exposes functionalities based on user roles, thereby enhancing security and user experience.

![Login](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/login.png)
![Register](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/register.png)

### 🌐 Guest User Capabilities
- **Interactive Apartment Search**: Leveraging the TomTom API, guests can conduct comprehensive searches for available apartments. The intuitive search interface allows for refined filtering options, ensuring users find precisely what they are looking for.
- **Direct Communication with Property Owners**: Guests can contact property owners directly via the application, simplifying the process of inquiry and negotiation.

![Search Listings](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/apartments_list.png)

### 📝 Registered User Capabilities
- **Comprehensive Listing Management**: Registered users enjoy the privilege of creating, modifying, and deleting their apartment listings. This functionality is designed to offer maximum flexibility and control over property advertisements.

![Edit Listing](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/apartments_edit.png)
![Create Listing](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/apartments_create.png)

- **Advanced Analytics and Statistics**: Users have access to detailed analytics, providing insights into listing performance, including metrics such as view counts and user interactions. These analytics are critical for users to optimize their listings and improve visibility.

![View Statistics](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/views_stat.png)

- **Streamlined Messaging System**: The integrated messaging system allows registered users to maintain effective communication with potential renters. Users can keep track of all communications, ensuring timely and organized responses.
- **Enhanced Sponsorship and Payment Options**: The backend supports listing sponsorship, enabling users to increase their property’s visibility. The sponsorship process is complemented by a secure payment gateway that ensures transactions are handled safely.

![Sponsor Listing](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/sponsorship_selection.png)
![Payment](https://raw.githubusercontent.com/gianlivio/proj124-team5-be/main/sponsorship_payment.png)

## Technologies Utilized
- **Laravel**: Chosen for its elegance and robust features, Laravel serves as the backbone of the application, providing a scalable and maintainable framework for development.
- **MySQL**: This relational database management system is employed for its reliability and efficiency in handling complex queries and large datasets.
- **TomTom API**: Integrated to offer sophisticated location services, enhancing the user experience with dynamic and interactive map-based searches.

## API Documentation
The backend exposes a well-documented RESTful API, which facilitates seamless interaction between the frontend and backend systems. This API provides endpoints for a variety of operations, including user authentication, listing management, messaging, and payment processing.

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
