INSERT INTO `#__users` VALUES 
(63, 'agent1', 'agent1', 'agent1@agents.com', '17aed3937f0142ccae6480377ff0104a:v0DL5ej8Wqd08kNeG5obSAFn9uxYa7Pu', 'Registered', 0, 0, 18, '2011-06-23 11:30:10', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(64, 'agent2', 'agent2', 'agent2@agents.com', '31f998fed217f2ed1fd8aebfde04e288:tjzK1swpsbtQHEVdasGcuhxyU4Gbk4Kd', 'Registered', 0, 0, 18, '2011-06-23 11:30:29', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(65, 'agent3', 'agent3', 'agent3@agents.com', 'a509df77e5ca9e4fae0348770e61bfd1:85U7URdlttHtzGtxw6cVEo6WeQBJEeNc', 'Registered', 0, 0, 18, '2011-06-23 11:30:48', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(66, 'agent4', 'agent4', 'agent4@agents.com', '251be8d7cb6f6dbd0f4c31d13fcfd5bb:VPs01RWokUxn1KXYeh06g7EfUzRyCQsA', 'Registered', 0, 0, 18, '2011-06-23 11:31:09', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(67, 'agent5', 'agent5', 'agent5@agents.com', '8aae65458776b3290087c4e4005db584:owb1gxaghnPBzmQx5CHC6l6mWfE4j4m1', 'Registered', 0, 0, 18, '2011-06-23 11:31:24', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(68, 'agent6', 'agent6', 'agent6@agents.com', '610fd2155dfdf734b4cb5cd76fac666d:D3ys2Ml2glHpRowG6EdrYIQADrQnEvmu', 'Registered', 0, 0, 18, '2011-06-23 11:31:47', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(69, 'agent7', 'agent7', 'agent7@agents.com', '14bac2df35e6e2d83c2f7d640363debb:BfMzEeFrrVWIIGiebVclVyCKWb5h5YkE', 'Registered', 0, 0, 18, '2011-06-23 11:32:01', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n'),
(70, 'agent8', 'agent8', 'agent8@agents.com', '0e6646be137fc54bf45a757ed2e5a8fe:cK3CnfKb9dNB1KtpqvOTx4GmTb0Xmoua', 'Registered', 0, 0, 18, '2011-06-23 11:38:41', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=0\n\n');

INSERT INTO `#__core_acl_aro` VALUES 
(11, 'users', '63', 0, 'agent1', 0),
(12, 'users', '64', 0, 'agent2', 0),
(13, 'users', '65', 0, 'agent3', 0),
(14, 'users', '66', 0, 'agent4', 0),
(15, 'users', '67', 0, 'agent5', 0),
(16, 'users', '68', 0, 'agent6', 0),
(17, 'users', '69', 0, 'agent7', 0),
(18, 'users', '70', 0, 'agent8', 0);

INSERT INTO `#__core_acl_groups_aro_map` VALUES 
(18, '', 11),
(18, '', 12),
(18, '', 13),
(18, '', 14),
(18, '', 15),
(18, '', 16),
(18, '', 17),
(18, '', 18);

INSERT INTO `#__properties_profiles` VALUES 
(1, 63, 'Patti Junger', 'patti-junger', '', 0, '', '', 0, '3650 Habersham Rd', '', 'Atlanta', '30305', 'GA', 'United States', 0, 'pjunger@mysite.com', '(404) 504-0801', '(404) 262-1658', '404-849-1183', '', '', '', '', '', '1_p.jpg', '1_l.gif', '', 1, 1, 0, '0000-00-00 00:00:00', '*', 5, 5),
(2, 64, 'B DIANE ARNOLD', 'b-diane-arnold', '', 0, '', '', 0, '79 West Paces Ferry Rd. NW', '', 'Atlanta', '30305', 'GA', 'United States', 0, 'CustomerService@mysite.com', '404-352-2010', '404-352-8063', '', '', '', '', '', '', '2_p.jpg', '', '', 1, 2, 0, '0000-00-00 00:00:00', '*', 5, 5),
(3, 65, 'DEBRA JOHNSTON', 'debra-johnston', '', 0, '', '', 0, '3290 Northside Parkway, NW', '', 'Atlanta', '30327', 'GA', 'United States', 0, 'DEBRA@mysite.com', '(404) 237-5000', '(404) 924-6807', '(404) 312-1959', '', '', '', '', '', '3_p.jpg', '', '', 1, 3, 0, '0000-00-00 00:00:00', '*', 5, 5),
(4, 66, 'Harry Norman,Buckhead', 'harry-normanbuckhead', '', 0, '', '', 0, '', '', 'Atlanta', '', '', '', 0, 'fafa@mysite.com', 'Office: (404) 233-41', '', '', '', '', '', '', '', '4_p.jpg', '4_l.gif', '', 1, 4, 0, '0000-00-00 00:00:00', '*', 5, 5),
(5, 67, 'TROY STOWE', 'troy-stowe', '', 0, '', '', 0, '3284 Northside Parkway', '', 'Atlanta', '30327', 'GA', 'United States', 0, 'troystowe@mysite.net', '(404) 890-7635', '(404) 261-6300', '(770) 314-7251', '', '', '', '', '', '5_p.jpg', '5_l.gif', '', 1, 5, 0, '0000-00-00 00:00:00', '*', 2, 5),
(6, 68, 'Luxe Estates Collection', 'luxe-estates-collection', '', 0, '', '', 0, '810 S. Durango Drive', '', 'Las Vegas', '89145', 'NV', 'United States', 0, 'team@mysite.com', '(702) 684-6100', '(702) 494-8270', '(702) 400-0645', '', '', '', '', '', '6_p.jpg', '6_l.jpg', '6_ll.jpg', 1, 6, 0, '0000-00-00 00:00:00', '*', 5, 5),
(7, 69, 'Jonathan Taylor', 'jonathan-taylor', '', 0, '', '', 0, '1206 30th St NW', '', 'Washington', '20007', 'DC', 'United States', 0, 'jonathan@mysite.com', '(202) 333-1212', '(202) 333-9396', '(202) 276-3344', '', '', '', '', '', '7_p.jpg', '7_l.gif', '', 1, 7, 0, '0000-00-00 00:00:00', '*', 5, 5),
(8, 70, 'Arnold Swatz', 'arnold-swatz', 'Agenzia Turistica Immobiliare', 0, '', '', 0, '1206 30th St NW', '', 'Atlanta', '63039', 'GA', 'United States', 0, 'agencia@agencia.com', '00 39 0735-75.33.23', '00 39 0735-44.61.19', '(202) 276-3344', '', '', '', '', '', '8_p.jpg', '', '', 1, 8, 42, '2011-04-18 19:06:01', '*', 20, 5);
