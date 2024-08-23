## Checklist

- [x] **DO Level Logic**
    - If DO < 3: Turn on Switch/Relay 1, 2, 3, 4, 5, 7.
    - If DO < 4.5: Turn on Switch/Relay 2, 3, 4, 5, 7.
    - If DO < 6: Turn on Switch/Relay 1, 2, 4, 5.
    - If DO > 6: Turn on Switch/Relay 2, 4, 6, 7.
    - If DO = 8: Turn off all Switches/Relays.

- [ ] **Aerator Logic**
    - Ensure all aerators stop for 15 minutes after running for two consecutive hours.

- [x] **Mobile App Control**
    - Implement on/off control for all switches (1 to 8) via the mobile app (manual override).

- [x] **PH Logic**
    - If PH < 6: Adjust PH to `PH + 1.5`.
    - If PH > 9: Adjust PH to `PH - 1.5`.

- [ ] **Machine Operation**
    - The list should include the runtime of each aerator.

- [x] **Sensor Data Display**
    - Display the average value of sensors over the last 24 hours on the home page of both
      - [x] The web
      - [x] Mobile apps

- [ ] **Cloud Icon**
    - Highlight or enlarge the cloud icon on mobile apps.

- [ ] **User Account Creation**
    - Create a user account with the following credentials:
        - **Email**: `trishal-catfish@smartfishbd.xyz`
        - **Password**: `Trishal123`
