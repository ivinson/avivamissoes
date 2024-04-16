<?php 



  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
  echo "<h1>" . date("Y-m-d H:i:s") . "</h1>";

  $arrFiles = array(
    "retorno/anexos/movimentobancario/01bfa71d78028bd6b636402f965596ed.jpg",
"retorno/anexos/movimentobancario/02514f631b206863e4e58c3658b8bde6.jpg",
"retorno/anexos/movimentobancario/02e48b60fd561693cb5aee57f39f4e1d.jpg",
"retorno/anexos/movimentobancario/030071857f607b583eb1915b203254c5.png",
"retorno/anexos/movimentobancario/032e33c6258df5ee3689a8ccc2e3737a.jpg",
"retorno/anexos/movimentobancario/041b9863c11784d9cb31bf92ae2c2899.jpg",
"retorno/anexos/movimentobancario/051215db0c0315c7576517ee7a2f60b6.jpg",
"retorno/anexos/movimentobancario/05dd48608b884e6a6b6a016a73119017.jpg",
"retorno/anexos/movimentobancario/060101b95f2b645e4c1d384b38c30c92.jpg",
"retorno/anexos/movimentobancario/072efdfc520e6c67658f6acc399c1dd2.jpg",
"retorno/anexos/movimentobancario/0747d334c6a1e7ca969bcadbb43d962c.jpg",
"retorno/anexos/movimentobancario/074cb782fb4bbaabe92d5d7a32232d72.jpg",
"retorno/anexos/movimentobancario/0760d65f3d1c88d21ad8419dc3d9a875.jpg",
"retorno/anexos/movimentobancario/0825d0a122ef566ec8a7bceb5711e18f.png",
"retorno/anexos/movimentobancario/08826308cbb540b42978a40c2b065fb4.jpg",
"retorno/anexos/movimentobancario/08d63185c34763fe95a5728f2fcfdcde.jpg",
"retorno/anexos/movimentobancario/0962086dbd86839ee8afca33348aa60f.jpg",
"retorno/anexos/movimentobancario/0a369a1665f16e5d03eeeacfa5d38bdb.jpg",
"retorno/anexos/movimentobancario/0a65f04dcacbed694a6b96f978fa7bfc.jpg",
"retorno/anexos/movimentobancario/0ac956b0c43b54e21ac113b4a265726b.jpg",
"retorno/anexos/movimentobancario/0af9bb102a7aa167bdf69b876abc2339.jpg",
"retorno/anexos/movimentobancario/0b158314ada576af413bb52b2bacc09d.jpg",
"retorno/anexos/movimentobancario/0bbf9c91bb044f2750cca6d19bc8f0e7.jpg",
"retorno/anexos/movimentobancario/0bf03abe84dd9562944ee0cb080aa298.jpg",
"retorno/anexos/movimentobancario/0c8d82a713ce8d180c7e1fc64cea0379.jpg",
"retorno/anexos/movimentobancario/0c902df0e4e067a177366acaa168b50e.jpg",
"retorno/anexos/movimentobancario/0dd5549fe425bfd7cc1e1305e26ba005.jpg",
"retorno/anexos/movimentobancario/0e40828a9c9e1feaf7987d53155ad6fd.jpg",
"retorno/anexos/movimentobancario/0e8301f98053d09c6c38ec0b02cfc4cf.jpg",
"retorno/anexos/movimentobancario/0e85d3964670e0e76d83ed058c99384e.jpg",
"retorno/anexos/movimentobancario/0f582d4a106b9b70d5b0dd0fe532d54e.jpg",
"retorno/anexos/movimentobancario/1022250a043b891cedcba732e28f3685.jpg",
"retorno/anexos/movimentobancario/10a5b3dc289f175ef81c5b8d78601a52.jpg",
"retorno/anexos/movimentobancario/128df26ae7c502e2f2fc350cb16a1675.jpg",
"retorno/anexos/movimentobancario/12d4e4c4c1be568178572864df8c3226.jpg",
"retorno/anexos/movimentobancario/135f40ba248eba22200962675876bcee.jpg",
"retorno/anexos/movimentobancario/14894b70618987db39d795e0331f9377.jpg",
"retorno/anexos/movimentobancario/151a2f9206980cbc0790be3a5a99317c.jpg",
"retorno/anexos/movimentobancario/154f96479ed5f5ed3e7b2ff8309cb921.png",
"retorno/anexos/movimentobancario/157af6954d3695d5b9083c53f82da255.jpg",
"retorno/anexos/movimentobancario/15d8d1f4e4c22c8d028277859cf76aa0.jpg",
"retorno/anexos/movimentobancario/15e8898d044adfdcba565fa2d3639ebf.jpg",
"retorno/anexos/movimentobancario/162b0efc895b80eb138115b07928aa45.pdf",
"retorno/anexos/movimentobancario/17089a97f15098e3e7a71deae515c219.jpg",
"retorno/anexos/movimentobancario/17d330f9a2b6c968580bbf33ddcc0c57.jpg",
"retorno/anexos/movimentobancario/1813e6c5c6abd5a937036c8dc6faa1c5.jpg",
"retorno/anexos/movimentobancario/18788520c65d100f380138501a362ba3.jpg",
"retorno/anexos/movimentobancario/191cc2d1a7c0a72a9ff0559f0f36dbcf.png",
"retorno/anexos/movimentobancario/1a829614fc0c6fc65ee3347821df06a3.jpg",
"retorno/anexos/movimentobancario/1b3ba9d9d59fc39c7d30249cf6b83e1f.jpg",
"retorno/anexos/movimentobancario/1b3c4fa95320db11b60cbd36a829256d.jpg",
"retorno/anexos/movimentobancario/1b78ec992a7cf29401d4992237f5efa8.png",
"retorno/anexos/movimentobancario/1c1922ebdf4fac00991cd53dc88cf73a.jpg",
"retorno/anexos/movimentobancario/1c2dae96d0c3fd7ac0ee61d3706d42c3.jpg",
"retorno/anexos/movimentobancario/1c890052ef80b3366aec0decc4d06e5a.jpg",
"retorno/anexos/movimentobancario/1ce8aed5a89b4e44764c1fe689666072.jpg",
"retorno/anexos/movimentobancario/1dc6b8f614b3fc3550c68743539eccc6.jpg",
"retorno/anexos/movimentobancario/1e55fc18bd312f94de86af11a43f8dc2.jpg",
"retorno/anexos/movimentobancario/1ea6b1b54c917be4c10310fae3a39f97.jpg",
"retorno/anexos/movimentobancario/1eb75a862d7c1db7b4b463fef1be4e15.jpg",
"retorno/anexos/movimentobancario/1ed86428956fbf44ce8c5db0631ef523.jpg",
"retorno/anexos/movimentobancario/1f02466ee2096c7af266fad2aa021c4f.jpg",
"retorno/anexos/movimentobancario/235180bcd353a102c013dc79344c3b64.jpg",
"retorno/anexos/movimentobancario/241821875ab95894c7d26d7af31bc703.png",
"retorno/anexos/movimentobancario/253d5394130a75975b0fe8e3139290f1.jpg",
"retorno/anexos/movimentobancario/25d8c5a8a53ec7e39f5dfd03b9075472.jpg",
"retorno/anexos/movimentobancario/26b0d7649c0048bc267865314319bca6.jpg",
"retorno/anexos/movimentobancario/289f4706f28f7b97533088cb565489a9.jpg",
"retorno/anexos/movimentobancario/29c221dcc65195710ba89e23efce3e60.jpg",
"retorno/anexos/movimentobancario/2c26c1064a7d3e7445d1c5cbad6ff328.jpg",
"retorno/anexos/movimentobancario/2c5f3ffddcac48e156ae94b7730615b2.png",
"retorno/anexos/movimentobancario/2d01989cef077cacb94a593cfd2eab96.pdf",
"retorno/anexos/movimentobancario/2d8344266336db3e1f6ab562bc41c48c.jpg",
"retorno/anexos/movimentobancario/2dc3ef3381da6e725aa23c0451d61c71.jpg",
"retorno/anexos/movimentobancario/2dcd019643811b10206386be8915648b.jpg",
"retorno/anexos/movimentobancario/2ee69e09fdd3f8ee3f4b369ebcdaa3ea.jpg",
"retorno/anexos/movimentobancario/2f149ea4fef3e1335d8edfeb7c251dfb.jpg",
"retorno/anexos/movimentobancario/2f160e9eefe60a6759a9a225ea1f825e.jpg",
"retorno/anexos/movimentobancario/303d7bc10de64f2557bee00c7888dd7c.png",
"retorno/anexos/movimentobancario/30e77103cbc2266ad53e1615b2ff0368.jpg",
"retorno/anexos/movimentobancario/31386cbc356ba42eed82a41ad78a1dae.png",
"retorno/anexos/movimentobancario/319ecac2dced533be6f991d0425126f3.jpg",
"retorno/anexos/movimentobancario/3443a2aec7ef3fe8d93b13a94b59df7a.jpg",
"retorno/anexos/movimentobancario/348b32a5c630f1916f70ece5671f4b68.jpg",
"retorno/anexos/movimentobancario/35a6d3577da4b8e00ea4de6c42890257.jpg",
"retorno/anexos/movimentobancario/35d707a5116a9181db1bf49a043bb3a6.jpg",
"retorno/anexos/movimentobancario/36a080cc9606f2c393330deab4997696.jpg",
"retorno/anexos/movimentobancario/36c2fed2580aa21a50b25de2ce03f34e.jpg",
"retorno/anexos/movimentobancario/36e8bea2da0e7b5546b1084ab331ce56.jpg",
"retorno/anexos/movimentobancario/37e2863547567f1adc50f6940db47da9.jpg",
"retorno/anexos/movimentobancario/387dd8cac3d9313060c52dc925031562.png",
"retorno/anexos/movimentobancario/391b30cf6774438516d16bc271f22eef.jpg",
"retorno/anexos/movimentobancario/395e50f563d76e84b0b801a1dc861c27.jpg",
"retorno/anexos/movimentobancario/39b320e719de1216c26a7ce2286aa510.jpg",
"retorno/anexos/movimentobancario/3a54f8b33f75cc87a883472c394b0476.jpg",
"retorno/anexos/movimentobancario/3a629a56e6fc01ea4b75bb998356dcd1.jpg",
"retorno/anexos/movimentobancario/3ab6de96ed2b83beb7916be0a03ccaac.jpg",
"retorno/anexos/movimentobancario/3af31cf96a1e98091957eeaf6121521a.jpg",
"retorno/anexos/movimentobancario/3af355b342f0fcd41527c8625a81826c.jpg",
"retorno/anexos/movimentobancario/3b92599d0203af2a2d7c5e365f964d6a.jpg",
"retorno/anexos/movimentobancario/3cbdffe97479782c2a84683ea7699abf.jpg",
"retorno/anexos/movimentobancario/3d386051c769945031e668ff17ffdb70.jpg",
"retorno/anexos/movimentobancario/3f29bf08d3321992b40fe506e5ca62b5.jpg",
"retorno/anexos/movimentobancario/3fa112ba88d9c9427e825c034bddcfb0.jpg",
"retorno/anexos/movimentobancario/406faaad41f9c136593b9d130518c7e7.jpg",
"retorno/anexos/movimentobancario/42515affff631c729a7e02b78d59d2ca.jpg",
"retorno/anexos/movimentobancario/428c54fa0ba5dc1118484a4b46f0bba9.jpg",
"retorno/anexos/movimentobancario/42f9173957810e5174988a0ece888c97.png",
"retorno/anexos/movimentobancario/4380e4081ff2fd5daad2f14366dafadb.jpg",
"retorno/anexos/movimentobancario/44068d685fdc31f75a468ae2c6e087e8.jpg",
"retorno/anexos/movimentobancario/4416927c48a3a9efb60db41d364133f2.jpg",
"retorno/anexos/movimentobancario/460f59537884fcb8f70bdb41a1dff5d7.jpg",
"retorno/anexos/movimentobancario/4716faa92ab955c8d10d70d51e793a95.jpg",
"retorno/anexos/movimentobancario/48452f3f76a26bafdb1c57a96f305ad4.jpg",
"retorno/anexos/movimentobancario/4897fc458855516ba045cfbc8b3ce3dd.jpg",
"retorno/anexos/movimentobancario/49d4ad400e0cc2247257ea353304cb21.jpg",
"retorno/anexos/movimentobancario/4b4a20a0227c968c77a2eacd7cd2454a.jpg",
"retorno/anexos/movimentobancario/4b62ce9cfdb94aea89c36f71a06db2df.jpg",
"retorno/anexos/movimentobancario/4b90526e046c6414cbc52674a0d998f4.jpg",
"retorno/anexos/movimentobancario/4b94bf68b7d90e965c3647d173462a31.jpg",
"retorno/anexos/movimentobancario/4cbe45229fdb57995afe1cda3d7f14f2.jpg",
"retorno/anexos/movimentobancario/4cf66da3497032d62f741b1157134f77.jpg",
"retorno/anexos/movimentobancario/4d24e6efd1021c10b63f0c72d5076030.jpg",
"retorno/anexos/movimentobancario/4d39aad714c757051f582f40a4054fc9.jpg",
"retorno/anexos/movimentobancario/4dae96e8f4c64ba592584c2171324b02.jpg",
"retorno/anexos/movimentobancario/4e235be454dc6ff04c005e98cccca7bd.jpg",
"retorno/anexos/movimentobancario/502482e74dad40b57b9723cea84f361a.jpg",
"retorno/anexos/movimentobancario/50da8a547a1196781c78b4e89a820c41.jpg",
"retorno/anexos/movimentobancario/50fbba5934c2d55f2e22ac3489d1441b.jpg",
"retorno/anexos/movimentobancario/510445073214e2e98deb3254ffe79d05.jpg",
"retorno/anexos/movimentobancario/5127cef82a5032c3aa5c9f713d2e7c3b.jpg",
"retorno/anexos/movimentobancario/515e9a92906beb6e217aa5fa24385fb9.jpg",
"retorno/anexos/movimentobancario/519374c1dd3552d99b9ba7ac11ec79cb.jpg",
"retorno/anexos/movimentobancario/51b2049777424091982f2a61c6187795.jpg",
"retorno/anexos/movimentobancario/5306e06740301e37b5a4d08fe611aa30.jpg",
"retorno/anexos/movimentobancario/549fe630eedbb5cc7cc04918566e58f1.jpg",
"retorno/anexos/movimentobancario/557edfd84d2a766b3eb9fa1df719bd05.jpg",
"retorno/anexos/movimentobancario/55bb9f8fcc8f5a2107e209b19858ab72.jpg",
"retorno/anexos/movimentobancario/569937693beddb75b6ccc483cdfde0bc.jpg",
"retorno/anexos/movimentobancario/578fb22af30fc0f8aaba3a52fd05643b.jpg",
"retorno/anexos/movimentobancario/58436567766c68b959625c473138310e.jpg",
"retorno/anexos/movimentobancario/58d5841cc9936153c6bbc00a65a589b9.jpg",
"retorno/anexos/movimentobancario/59b462ad41995a5a10cd365598c3bf76.jpg",
"retorno/anexos/movimentobancario/5a27adc505c0212e9d0887769947b729.jpg",
"retorno/anexos/movimentobancario/5a483c2167964a60ef24c233f5ef1bbf.jpg",
"retorno/anexos/movimentobancario/5a9e041b02e8ad0a1c2392b763880772.jpg",
"retorno/anexos/movimentobancario/5ab9cd0c6943980d1486f891b8dedbd3.jpg",
"retorno/anexos/movimentobancario/5c155d30509169849a5e88e00974225b.jpg",
"retorno/anexos/movimentobancario/5da505c0b14108baa1e075190fbd2fb6.jpg",
"retorno/anexos/movimentobancario/5dd4898df4766cb91d17186135b8f8a3.jpg",
"retorno/anexos/movimentobancario/5e95252cc31f3eb2fa228c83bb4ac132.jpg",
"retorno/anexos/movimentobancario/5eaa518c9966a36cfc4f71f09b2d4ad3.jpg",
"retorno/anexos/movimentobancario/5ec99eabc62a54076f4d0942dd892199.jpg",
"retorno/anexos/movimentobancario/5ed08632cf9c5c6d10ef7fd120a2e640.jpg",
"retorno/anexos/movimentobancario/5f7a9a8216cde3fa529440cd30885b2a.jpg",
"retorno/anexos/movimentobancario/5fc3e1401c1d102be9939d1d87cb5986.jpg",
"retorno/anexos/movimentobancario/600a225ca781a7262feaa720e546567c.jpg",
"retorno/anexos/movimentobancario/604e5612059969fcc1ec5468d2b1c495.jpg",
"retorno/anexos/movimentobancario/60b65166c7aff4a93e3062fe93da41cb.jpg",
"retorno/anexos/movimentobancario/624b704282e916d58c22c4c7d0ebe638.png",
"retorno/anexos/movimentobancario/62f1061a7310e07bdc97d0c53d1986f4.jpg",
"retorno/anexos/movimentobancario/63651448d4fdf872af396e4518a1ee08.jpg",
"retorno/anexos/movimentobancario/638419a2f0615bfcf3dfe10880b2ffa5.jpg",
"retorno/anexos/movimentobancario/64f70cb76519e62d99df8bd77fcfb735.jpg",
"retorno/anexos/movimentobancario/65a6d3e9779a4f2dd92c79368b29907d.jpg",
"retorno/anexos/movimentobancario/66e56b18c356583840638198e2847346.jpg",
"retorno/anexos/movimentobancario/68914df0eddfb239ef810e498e4bd587.jpg",
"retorno/anexos/movimentobancario/6b842f4d671736af4b912d28ddc9cf7b.jpg",
"retorno/anexos/movimentobancario/6b91acb35e2b376436219014ea52667e.png",
"retorno/anexos/movimentobancario/6bfde7053ac3482bfa883be8270e0bab.jpg",
"retorno/anexos/movimentobancario/6c49f32757f1657f019c111800e558ce.jpg",
"retorno/anexos/movimentobancario/6cb18f52a4945bbd051aed58d82af962.jpg",
"retorno/anexos/movimentobancario/6cc55e99f8dabddadc7a924ba36539c5.jpg",
"retorno/anexos/movimentobancario/6cffb9fe391d39a4afcd990d48e1d1f0.jpg",
"retorno/anexos/movimentobancario/6d9fba65d51e883680a0ba2a134e092e.jpg",
"retorno/anexos/movimentobancario/6de781e185ccdf00a439bb93fc863ff3.jpg",
"retorno/anexos/movimentobancario/6e561b0d963d0d96bb60b958b7514719.jpg",
"retorno/anexos/movimentobancario/6ea92b2ae809a23193bbd9d7632eb6b0.jpg",
"retorno/anexos/movimentobancario/6ef8f6578b2b646bbde451630617e654.jpg",
"retorno/anexos/movimentobancario/6f255f179b2dda6c9e47471955949ab5.jpg",
"retorno/anexos/movimentobancario/6f4702613e91832b4143ab12ac4b641c.jpg",
"retorno/anexos/movimentobancario/710f64109e3c6c02d1912fc8294f1022.jpg",
"retorno/anexos/movimentobancario/71770210620fe7ec09fa2621ef9e0b0c.jpg",
"retorno/anexos/movimentobancario/71a71cdba7510008867cddbc6d592d2b.jpg",
"retorno/anexos/movimentobancario/71a757451ebdb8af758c02f9f7ca817e.jpg",
"retorno/anexos/movimentobancario/71bbed36ebd3b6e2763d4096f17e7c99.jpg",
"retorno/anexos/movimentobancario/72957a7b3cc70401a3e93e71f685f1f4.jpg",
"retorno/anexos/movimentobancario/732d5d62e593cdd7094b8a250244c514.jpg",
"retorno/anexos/movimentobancario/7369b7add0ae01cd34122cc47302100e.jpg",
"retorno/anexos/movimentobancario/740c2d64a3d948e41e790a11cf5478f5.jpg",
"retorno/anexos/movimentobancario/761bc92b13ec35f5db4874c5824c3a3b.jpeg",
"retorno/anexos/movimentobancario/7628540518965ef4884637d3f959d37c.jpg",
"retorno/anexos/movimentobancario/770950a2d94b4f694b8f721767afc6d7.png",
"retorno/anexos/movimentobancario/77bd74a8bd367958f7dc928fae1d1533.png",
"retorno/anexos/movimentobancario/79097a77787caa68ed82b82e96167107.jpg",
"retorno/anexos/movimentobancario/7997ced6686f89dd880d370e1766c95f.jpg",
"retorno/anexos/movimentobancario/79d4420ed5ad9fd47120e02be89548b2.jpg",
"retorno/anexos/movimentobancario/7b33679cc934c85dd1a7073d7be83bed.jpg",
"retorno/anexos/movimentobancario/7bf9ce63fb64e796dff32f6df4658811.jpg",
"retorno/anexos/movimentobancario/7cc24ca553fe08eed64fada2ab610aab.jpg",
"retorno/anexos/movimentobancario/7da98347c5f84105eae50de2b1f549e4.pdf",
"retorno/anexos/movimentobancario/7ee42c99071c7e565b8dd3619ad4d75c.jpg",
"retorno/anexos/movimentobancario/7f4aa2b7282aabd0b89c4bfc67dbed74.jpg",
"retorno/anexos/movimentobancario/7fd6274627ebd842ce6f2d54974989b0.jpg",
"retorno/anexos/movimentobancario/7fe485f9adaac6d092af9cc9696142f7.jpg",
"retorno/anexos/movimentobancario/80e34184c3d52474090a0a0f180612e2.jpg",
"retorno/anexos/movimentobancario/8101ecdc7e82d62eb5a876baa9122af7.jpg",
"retorno/anexos/movimentobancario/8236bf0f69334db38c87eb418eb4f154.jpg",
"retorno/anexos/movimentobancario/84217d8f0bec60bf858d501ad53e2135.jpg",
"retorno/anexos/movimentobancario/850a6164b9ba0fcc2d79cf7de37406d6.jpg",
"retorno/anexos/movimentobancario/85e4848c646f6fcf4bba17a18ad15f70.jpg",
"retorno/anexos/movimentobancario/86ae3224b9e7aca8aa48f7f2f7f996a4.jpg",
"retorno/anexos/movimentobancario/886720a01670069be2471a75a41c7996.jpg",
"retorno/anexos/movimentobancario/892cbb34f9b7273db34a189a0ae1d0d9.jpg",
"retorno/anexos/movimentobancario/898756a0ee0c9d64087eacc57763c937.docx",
"retorno/anexos/movimentobancario/8a53071e5b888c23b411205f56962f3d.jpg",
"retorno/anexos/movimentobancario/8b293e438294594f8c98d37b6a301e02.jpg",
"retorno/anexos/movimentobancario/8b60c46314a2b74017d15e9b85a909db.jpg",
"retorno/anexos/movimentobancario/8cd6fe76303bf661346b3d50908fb21f.jpg",
"retorno/anexos/movimentobancario/8d02993d32e72cee23a94744e85ee762.jpg",
"retorno/anexos/movimentobancario/8d2548098b363fb86a7a469c65b43a5b.jpg",
"retorno/anexos/movimentobancario/8d674434c16cbeaf1134d6d89a546681.jpg",
"retorno/anexos/movimentobancario/8dbcf0bb4429f81738fb2e706cddf9ee.jpg",
"retorno/anexos/movimentobancario/8dc6939aa068ce5ea2f92bde65dc158b.jpg",
"retorno/anexos/movimentobancario/8e02b5851c9ea691e31c719947998762.jpg",
"retorno/anexos/movimentobancario/8ea3f1db395b4e4e2e91f01165db0b2d.jpg",
"retorno/anexos/movimentobancario/8ee827ed5f265f71e3dbd2637ab3737c.jpg",
"retorno/anexos/movimentobancario/90c4aa184184fce47edb874b4444589d.jpg",
"retorno/anexos/movimentobancario/90ce44c9765d8b0c3de46356b9c5ef64.jpg",
"retorno/anexos/movimentobancario/90f25a4c0c9319c1e0112bc34504afc4.jpg",
"retorno/anexos/movimentobancario/9165629426eed7e2869331f3ee3cb755.jpg",
"retorno/anexos/movimentobancario/9357364e11e9268fd1c1f46a10a03232.jpg",
"retorno/anexos/movimentobancario/942189c2e91c809f8c01465316d615bd.jpg",
"retorno/anexos/movimentobancario/945bcec0ee53ab5347c49665558affcd.jpg",
"retorno/anexos/movimentobancario/9491281ede327ec51d18ec9b4498bc28.jpg",
"retorno/anexos/movimentobancario/94dffceb88c2e965923ea4004ea0efc7.png",
"retorno/anexos/movimentobancario/95a0340a800df18c2b3ac0861815fd39.jpg",
"retorno/anexos/movimentobancario/96640f7e74a9ee179fbb0195d9154f22.jpg",
"retorno/anexos/movimentobancario/969d6a400c385b84ff201e33e15d2864.jpg",
"retorno/anexos/movimentobancario/97960a9e267349677f85194481f79c28.jpg",
"retorno/anexos/movimentobancario/97e21adb417e65f6de6d78aa316b0a0d.png",
"retorno/anexos/movimentobancario/98815fec5602369e3c2e7a746c513e11.jpg",
"retorno/anexos/movimentobancario/9d01362c2d900763de26fe4f269f5cc4.jpg",
"retorno/anexos/movimentobancario/9d2fe033457ad7108f07b483a63bd16d.jpg",
"retorno/anexos/movimentobancario/9e05e4b4978898b50a948e5be32acb50.jpg",
"retorno/anexos/movimentobancario/9f1501f13f9be753277520c21fe05f0f.jpg",
"retorno/anexos/movimentobancario/9fb4fdb9e63ed50a1c93ad902413b430.jpg",
"retorno/anexos/movimentobancario/a01687cfc8ebb443400a365f2b57f72f.jpg",
"retorno/anexos/movimentobancario/a102beaf5eb619e2d934550a39f9bc64.jpg",
"retorno/anexos/movimentobancario/a111b756925478aa71de610abaa05e19.jpg",
"retorno/anexos/movimentobancario/a122904f0957325ad0c20352cbdc3a9b.jpg",
"retorno/anexos/movimentobancario/a1b000d1fc160b498cc339fe3f69173a.jpg",
"retorno/anexos/movimentobancario/a1cb71322b319c11a07d8d38bbf4715b.jpg",
"retorno/anexos/movimentobancario/a2f0eead09998e6cc190da929bb6caa2.jpg",
"retorno/anexos/movimentobancario/a31312a750e00e461b91e64ae9c310b8.jpg",
"retorno/anexos/movimentobancario/a3e07889a3911af4a30a50377f6a2d03.jpg",
"retorno/anexos/movimentobancario/a41d0a615d3e4631e6bf7321621343eb.jpg",
"retorno/anexos/movimentobancario/a454ea0aa25a002ac9381865fbd74f19.jpg",
"retorno/anexos/movimentobancario/a487dc353013c0964ed8cdb574df62c9.png",
"retorno/anexos/movimentobancario/a4f380f172a5fb8cf2e07772dc232311.jpg",
"retorno/anexos/movimentobancario/a4fe48d410b02ec54f8d9178aa84cf2f.jpg",
"retorno/anexos/movimentobancario/a62d9c44394fb7b160615a3136d02b35.jpg",
"retorno/anexos/movimentobancario/a64244fe03edf3e566590c911030d292.jpg",
"retorno/anexos/movimentobancario/a6813b9b7a5a4ccbfbd4a1704a418f6a.jpg",
"retorno/anexos/movimentobancario/a6990391d5ab7686b0aa1b07208d9bd9.jpg",
"retorno/anexos/movimentobancario/a758a39cbb365fb69fadfeb2389e49c8.jpg",
"retorno/anexos/movimentobancario/a87e2efe784b3bf7c87abeebfb51c495.jpg",
"retorno/anexos/movimentobancario/a8ae99350218bf6401c77e24f96358fd.jpg",
"retorno/anexos/movimentobancario/a97e53353bb056b2624c06538295d464.jpg",
"retorno/anexos/movimentobancario/aa215a0c94bc3d317d23b892691622bd.jpg",
"retorno/anexos/movimentobancario/aa241db6aa0c0c644b297eb0dcab747c.jpg",
"retorno/anexos/movimentobancario/aa6473984a43066064f1573100d112c7.jpg",
"retorno/anexos/movimentobancario/aa76f5328cca4472e86a741d15d706e8.jpg",
"retorno/anexos/movimentobancario/aace9d8080bd867640619b5cfd33d698.jpg",
"retorno/anexos/movimentobancario/ab3e1031c0569ed8d55b7b75bdcc7388.jpg",
"retorno/anexos/movimentobancario/ac4db3721cdefedd350f9aa6f8d6fbd7.jpg",
"retorno/anexos/movimentobancario/ad3e2c29df09446a2b58b8db234034f9.jpg",
"retorno/anexos/movimentobancario/adc52f80d83802b3e2fc2ff36d3f481b.jpg",
"retorno/anexos/movimentobancario/ae29a8f3109dd01cce6b1ebbfc28756e.jpg",
"retorno/anexos/movimentobancario/ae7603da97ced2b4bcff3c40ea30e239.jpg",
"retorno/anexos/movimentobancario/b0d0e32cb9a20fbcd38fee9fb6658acb.jpg",
"retorno/anexos/movimentobancario/b0d2aeb863d89a8be4d75acf9a8c5d0d.jpg",
"retorno/anexos/movimentobancario/b0fa83729431c8952c9bc4c6d0962a01.jpg",
"retorno/anexos/movimentobancario/b166b3064d83b7ec11c615fdd3d452b1.jpg",
"retorno/anexos/movimentobancario/b2488234de2c49c18bda39f95d51d0ca.jpg",
"retorno/anexos/movimentobancario/b2aab5d80a131e44235a3a126fdf93fc.jpg",
"retorno/anexos/movimentobancario/b45f789098b16a84ac4cc4634f7a8055.png",
"retorno/anexos/movimentobancario/b48ad4c3a8a01fc054251df81ad871e3.jpg",
"retorno/anexos/movimentobancario/b615f5269f5cefeddcf4ef3dd46526af.jpg",
"retorno/anexos/movimentobancario/b648c5b3af10bb0d47ad2215f9766b4a.jpg",
"retorno/anexos/movimentobancario/b6e23ebe6f9e3a79390259960ebf7e94.jpg",
"retorno/anexos/movimentobancario/b7231c33980a66c47c60a83a6bb83a8c.jpg",
"retorno/anexos/movimentobancario/b72ed28aca4ea6f172fb2e8c1aa528cd.jpg",
"retorno/anexos/movimentobancario/b8a8822d61c90443c1f8f34cb378b1a1.png",
"retorno/anexos/movimentobancario/bb17718bbea7f84696a36e6ccd4be8c1.jpg",
"retorno/anexos/movimentobancario/bb5bb2c50a954720d974fa9ab358a8a1.jpg",
"retorno/anexos/movimentobancario/bbd2a8eaeaeb7348a8caa908aa1889f6.jpg",
"retorno/anexos/movimentobancario/bc924df17d7ad17231562e23bd389beb.jpg",
"retorno/anexos/movimentobancario/bc9a49b3345cc9464a3b33c09d97b5ca.jpg",
"retorno/anexos/movimentobancario/bcc3ffcd08ed29458e8fb4bd26f8fe30.jpg",
"retorno/anexos/movimentobancario/bdab93ac8a2adbc4cb65476e900dfbf7.jpg",
"retorno/anexos/movimentobancario/bf597312df40ff2c8ff1f3031a38d643.jpg",
"retorno/anexos/movimentobancario/bf7c4580e606424fd4f3446908da4d45.jpg",
"retorno/anexos/movimentobancario/bfb9f3a760a264da2d447f9c2605a595.jpg",
"retorno/anexos/movimentobancario/c03c9a0bd19db1105ddca2c3f65e025f.jpg",
"retorno/anexos/movimentobancario/c09d43960f46ac32e13715d8371fbfbf.jpg",
"retorno/anexos/movimentobancario/c1d25d3bfba494fdfc1da8ec0d67a8dc.png",
"retorno/anexos/movimentobancario/c1f05a6ad85327ae52571603b7d4a0da.jpg",
"retorno/anexos/movimentobancario/c1f1bba4acbd74b8a955ade817f97065.jpg",
"retorno/anexos/movimentobancario/c38a86bc00b8a835e0557edc0fc4bd0e.jpg",
"retorno/anexos/movimentobancario/c3fff9aaa44a2e555e43a6703cbcc9c6.jpg",
"retorno/anexos/movimentobancario/c41390451a01f6ce7d58af3df23c15c6.jpg",
"retorno/anexos/movimentobancario/c483c75bac7f863c0fea6d89c81466e1.jpg",
"retorno/anexos/movimentobancario/c4be3cd292196fe82945f14b2b2b4007.jpg",
"retorno/anexos/movimentobancario/c52d2bbcc3895d81c1c26af9a94ca899.jpg",
"retorno/anexos/movimentobancario/c5d766c9cd8ee2f4f55f6aaa5d44e506.jpg",
"retorno/anexos/movimentobancario/c68911c28d61cd5561fdb38ba60201c8.jpg",
"retorno/anexos/movimentobancario/c6b9c9d58d2f3dc3272139ec53f6f3db.jpg",
"retorno/anexos/movimentobancario/c6c1af72a2aea0ae4808a4fca09cfdea.pdf",
"retorno/anexos/movimentobancario/c7c46f17edbf4627ffd5d8a1d5ca45bd.jpg",
"retorno/anexos/movimentobancario/c7de39c4c24e3a50c9c07f101b6720c3.jpg",
"retorno/anexos/movimentobancario/c7e180ef552826d19391e49f931c4b4d.jpg",
"retorno/anexos/movimentobancario/c82abb0b5d873d9bae4cfe3a91b65495.jpg",
"retorno/anexos/movimentobancario/c85d0573409f22a61d14e1e862b6f0ef.jpg",
"retorno/anexos/movimentobancario/c89792eedae87c7c70310f705177cbbf.jpg",
"retorno/anexos/movimentobancario/c8ec675b804f94c0db744014b902ba67.jpg",
"retorno/anexos/movimentobancario/c946736eb7a5cb7fe847a63fad239b1b.jpg",
"retorno/anexos/movimentobancario/ca7ee6d2e10526fc4ca07245c792499c.jpg",
"retorno/anexos/movimentobancario/caed74a01991be29b48705102f01ef30.jpg",
"retorno/anexos/movimentobancario/cbbf1e1840eda8d57e3c9db913075f9c.jpg",
"retorno/anexos/movimentobancario/cbcc4675fe0e95496b8bb2be922d5e50.jpg",
"retorno/anexos/movimentobancario/cbf45db6c41159681f6047b72117508e.jpg",
"retorno/anexos/movimentobancario/cc5b74498987e1ae9c6d13e5c21851de.jpg",
"retorno/anexos/movimentobancario/cc905ed85c0310fcc760089d77b79b7e.jpg",
"retorno/anexos/movimentobancario/cd15f9b0abcf28df67b7552ed61f01f3.jpg",
"retorno/anexos/movimentobancario/cec7b1e61a9ad7bda4633ce2c89ca38a.jpg",
"retorno/anexos/movimentobancario/cf14f325c631cfd2d335387460a22bcb.jpg",
"retorno/anexos/movimentobancario/d03e2ff5ebcc6306e91b029e9c952d5d.jpg",
"retorno/anexos/movimentobancario/d186a8387ab1536e908f91fe97f833df.jpg",
"retorno/anexos/movimentobancario/d236fe5cbcf3aaff68f4d914595cc63a.jpg",
"retorno/anexos/movimentobancario/d311ecc4856dd6cca794cd8fb28eeee1.jpg",
"retorno/anexos/movimentobancario/d336af37235de26c87c8f7a1808f19d2.jpg",
"retorno/anexos/movimentobancario/d36634fde7444aa55ad651af71b73101.jpg",
"retorno/anexos/movimentobancario/d39331651efa7632b96e1a69ce446274.png",
"retorno/anexos/movimentobancario/d3bb27ff9edfa320719b62d8af4e4269.jpg",
"retorno/anexos/movimentobancario/d4cfc34b312b7da9d7974d26d2f06629.png",
"retorno/anexos/movimentobancario/d632a5fa2a1718f379ff40634f7cefb1.jpg",
"retorno/anexos/movimentobancario/d74f45fa3f4c6332f7d65d9fab21ba0b.jpg",
"retorno/anexos/movimentobancario/d8cdb05e2cc639b73bc449f61253c1cf.jpg",
"retorno/anexos/movimentobancario/d8e0ff149ae07297ad09d5213bee166f.jpg",
"retorno/anexos/movimentobancario/d928e11efe1dbe489701dee49054f2d0.pdf",
"retorno/anexos/movimentobancario/d9c4ee2f73363e3f6a8002876ad3e6c7.jpg",
"retorno/anexos/movimentobancario/dbbe5446e5a228956e48b97ae9f9de52.jpg",
"retorno/anexos/movimentobancario/dc656029331f0b7b9be5aaf5a6465121.jpg",
"retorno/anexos/movimentobancario/dd2e6fe8742ba0b6943438ea5d830c18.jpg",
"retorno/anexos/movimentobancario/dd912e91870a33b411af8c8e3177a998.jpg",
"retorno/anexos/movimentobancario/dde9fe93eec12c0372c40b0b78048f81.jpg",
"retorno/anexos/movimentobancario/dfa8db4c390da503c1cdf0962d303df8.jpg",
"retorno/anexos/movimentobancario/dfc524677cfa1ac84d764976fe9a9c20.png",
"retorno/anexos/movimentobancario/dfd4b61bbe8587d6899a85c68d343cf1.jpeg",
"retorno/anexos/movimentobancario/dff16ab9cdb5ab71fcd7ded871a21f51.jpg",
"retorno/anexos/movimentobancario/e097e2485c69743f62b1863be75408eb.jpg",
"retorno/anexos/movimentobancario/e1e908d0951bae7f19b5580c2d780a7e.jpg",
"retorno/anexos/movimentobancario/e3650631652c45bcc2142b17519b47d9.jpg",
"retorno/anexos/movimentobancario/e3de0eac27e23de1324dd725d346f0fe.jpg",
"retorno/anexos/movimentobancario/e425e266204f6e3623b2f896f5986587.jpg",
"retorno/anexos/movimentobancario/e479038b54324ceceb9b7ee95a5f178d.jpg",
"retorno/anexos/movimentobancario/e52952906df624021b43110d194faa55.jpg",
"retorno/anexos/movimentobancario/e59ef1a4640b16c28010fdd022d79bb8.jpg",
"retorno/anexos/movimentobancario/e691a64d858544137d1e801dc787204d.jpg",
"retorno/anexos/movimentobancario/e81fa3f9cc2e7f71f6e9e05f690c9317.jpg",
"retorno/anexos/movimentobancario/e87a514e3c73d665b41d27bdf9acc91e.png",
"retorno/anexos/movimentobancario/e88a8e0fe0bc55431af061bc7f347e10.png",
"retorno/anexos/movimentobancario/e8a384afe65c040380e08ed64eee1a71.jpg",
"retorno/anexos/movimentobancario/e93a99bef98a4d8a5e0a41282241662d.jpg",
"retorno/anexos/movimentobancario/e9994979b9a4aec4d803670554054eb3.jpg",
"retorno/anexos/movimentobancario/e9e9ee14bf70deed30b72ea3d80550b6.jpg",
"retorno/anexos/movimentobancario/eb56a556f15859d78457ee7a3da56e2f.jpg",
"retorno/anexos/movimentobancario/eb678663933a384affcae374317acd73.jpg",
"retorno/anexos/movimentobancario/ebb52c53e84f269cfa26e28369b96cc0.jpg",
"retorno/anexos/movimentobancario/ed1d7ca6c17f3c42ede51c6f3f1dfe4e.jpg",
"retorno/anexos/movimentobancario/edb603d3168316298df5e818b9d2cf37.jpg",
"retorno/anexos/movimentobancario/ee86742eb34f9241eeeb6a33d101c941.jpg",
"retorno/anexos/movimentobancario/ef199555c7dd692ace3e7b3cc92c0620.jpg",
"retorno/anexos/movimentobancario/efb0cd958c8ec1f78cdb4041e011ba08.jpg",
"retorno/anexos/movimentobancario/f005a4f1bdf1d9c7b540898ea7418d47.jpg",
"retorno/anexos/movimentobancario/f19070bc05789833053dd9b0c440db5c.jpg",
"retorno/anexos/movimentobancario/f1d43f0c4984d7697846d4efde10e2c5.jpg",
"retorno/anexos/movimentobancario/f282abfa7b7d44189209ee7c6186b469.jpg",
"retorno/anexos/movimentobancario/f2a0538b059024e2da31bbc6d8ecc080.jpg",
"retorno/anexos/movimentobancario/f30c1abf44b714e7ef285a5f81b58003.png",
"retorno/anexos/movimentobancario/f40458846bc6075d87b6ca7bd354b537.jpg",
"retorno/anexos/movimentobancario/f485848e48010e19d2682ee6f1163d34.jpg",
"retorno/anexos/movimentobancario/f5282e0bdc7fbd2395096cf42de60e19.jpg",
"retorno/anexos/movimentobancario/f58489b7f72e12268d314617162a2346.jpg",
"retorno/anexos/movimentobancario/f64e56aac8ca0bcb987de2532fd0c2b3.jpg",
"retorno/anexos/movimentobancario/f6f5243b4885e291f3ed661aa64f3530.jpg",
"retorno/anexos/movimentobancario/f7e1eceb1c2ffb3cf0fe2aa1faeeb10f.jpg",
"retorno/anexos/movimentobancario/f81a206c7d2992290f8b4ae64c9b92cc.jpg",
"retorno/anexos/movimentobancario/f907f79c16b72391f934d420d06fa379.jpg",
"retorno/anexos/movimentobancario/f91ac74b2fb78ed21d7b854e40d2c3d3.jpg",
"retorno/anexos/movimentobancario/fab3035e27c4d19b5b41d2514835edb1.jpg",
"retorno/anexos/movimentobancario/fb3895f8b52ab43d115601ad72d4e7d8.jpg",
"retorno/anexos/movimentobancario/fc0861fb644b4d3a5642caa4bf3e0bef.jpg",
"retorno/anexos/movimentobancario/fcb41718604adad00a729357b7672c0a.jpg",
"retorno/anexos/movimentobancario/fdfec4d6ecb952ca49310be0db7f4d4c.jpg",
"retorno/anexos/movimentobancario/fe4cc130201cd3bc261c87814a0bc2b7.jpg",
"retorno/anexos/movimentobancario/ff595fc4cd81cdc9c3eb6cbf92ab35f0.jpg",
"retorno/anexos/movimentobancario/ffec57798c7946cd1de8fd274d08caa7.png"
);
      
?>


<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
<div class="col-lg-12">
  <h1 class="page-header">
  <img src="icon-boleto.jpg" width="100" height="100">

     Tela de Utilidades Gerais do Sistema
      <small></small>
  </h1>
  <ol class="breadcrumb">
      <li>
          <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
      </li>
      <li class="active">
          <i class="fa fa-file"></i> 
      </li>
      <LI>
      
      </LI>
  </ol>


<br>   <a href='utils.php?action=files' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
Verificar Arquivos sem lancamentos correspondentes </a>

<a href='verificar-integridade.php' class='btn btn-warning' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
Verificar Integridade </a>

<br><br>

<a  
	href='consistencia.php' 
	class='btn btn-warning' 
	role='button'> 
	Consistencia 
</a>

<br><br>


</div>
</div>  
<!-- /.row -->
<div class="row">
<div class="col-lg-12">
<?php 
        

if (isset($_GET['move']) ) { 

  #Move o arquivo referido para outra pasta
  $path = "retorno/anexos/movimentobancario/";
  $novoPath = "retorno/anexos/movimentodel/";

  $getPath =  $_GET["move"] ;

  $arquivo = explode("/", $getPath);
  echo $arquivo[3]; 


  //exit;

  rename($path.$arquivo[3], $novoPath.$arquivo[3]);
  $_GET['action'] = "files";


  
  echo  "de : " . $path.$arquivo[3];
  echo  "<br> para : ";
  echo  $novoPath.$arquivo[3];
  
  //exit();



}


$iTotal;
$iSemCorrespondentes;

if (isset($_GET['action']) ) { 






echo "  
<div class='table-responsive'>
  <table class='table'>
    <thead>
      <tr>
 
        <th>Arquivo</th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>";



  if($_GET['action'] == "files"){



    //$arr = array(1, 2, 3, 4);
    foreach ($arrFiles as &$value) {
        //$value = $value * 2;

      if (file_exists($value)) {


        #Verifico se existe esse anexo em algum lancamento no banco de dados
        $sql = "select * from lancamentosbancarios
                where Anexos = '$value'";

          $resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 
          $count = $resultLancamentos->num_rows;

      if ($count == 0){
      
        echo "
              <tr>
                <td><a target='_blank' href='".$value."'>".$value."</a><br /></td>
             
                <td>
                  <a href='listar-extrato.php' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
                  Identificar </a>

                  <a href='nova-entrada-direta.php?lk=".$value."' class='btn btn-success' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
                  Novo Lançamento </a>

                   <a href='utils.php?move=".$value."' class='btn btn-danger' role='button'><span aria-hidden='true'></span> 
                  X </a>         

                </td>
              </tr>
              ";
            }
    }
}
    //exit;

   #################################################################
   #################################################################
   ##################################
   #####################
   ##########
   #####
   ##
   #
       
/*
   $path = "retorno/anexos/movimentobancario/";
   $diretorio = dir($path);
    
    echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";    




   echo "<br> Total::: " . $diretorio -> read() ."<br>";
   while($arquivo = $diretorio -> read()){
    $iTotal++;
     
             //if($iSemCorrespondentes > 10){continue;}
     //  continue;      
    #Verifico se existe esse anexo em algum lancamento no banco de dados
    $sql = "select * from lancamentosbancarios
            where Anexos = 'retorno/anexos/movimentobancario/{$arquivo}'";

      $resultLancamentos = $db->query($sql) or trigger_error($db->errorInfo()[2])(mysql_error()); 
      $count = mysql_num_rows($resultLancamentos);
      if ($count == 0){

        $iSemCorrespondentes++;
        
        if($iTotal > 2){
        
        $filename = $path.$arquivo;

        $DataArquivo = date ("d/m/y", filemtime($filename));

        echo  "\"".$filename."\",";
        //echo $filename;
        echo "<br>";


/*
      echo "
      <tr>
        <td><a target='_blank' href='".$path.$arquivo."'>".$arquivo."</a><br /></td>
        <td>{$DataArquivo}</td>
        <td>
          <a href='listar-extrato.php' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
          Identificar </a>

          <a href='nova-entrada-direta.php?lk=".$path.$arquivo."' class='btn btn-success' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
          Novo Lançamento </a>

           <a href='utils.php?move=".$arquivo."' class='btn btn-danger' role='button'><span aria-hidden='true'></span> 
          X </a>         

        </td>
      </tr>
      "; 



      }
          #echo "<a target='_blank' href='".$path.$arquivo."'>".$arquivo."</a><br />";
         

      }

      
   }

   $diretorio -> close();  

*/
   #################################################################
   #################################################################
   ##################################
   #####################
   ##########
   #####
   ##
   #






  } 

}


echo "  </tbody></table></div>";
echo "Total de Arquivos na pasta<h1>{$iTotal}</h1> <br>";
echo "Total de Arquivos sem correspondentes <h1>{$iSemCorrespondentes}</h1> <br>";


include("footer.php");



exit(); 

#TROCAR USUARIO PRODUCAO
$resultBoletos = $db->query("
    select * from contasreceber
        where Status='Pago'

")->results(true) or trigger_error($db->errorInfo()[2]); 


foreach($resultBoletos as $rowOption){ 
  foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }  


    #Para cada boleto pago verifico se tem um lancamento bacario
    #correspondente. Senao, Crio com o valor e a data de referencia do boleto

      #TROCAR USUARIO PRODUCAO
    $sql = "select * from lancamentosbancarios
              where idContaReceber = {$rowOption['id']}";

      $resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 


      $count = $resultLancamentos->num_rows;

      if ($count == 0){
        //echo $sql."<br>";
        echo " Boleto {$rowOption['NossoNumero']}  de Valor {$rowOption['Valor']} não encontrado. <br>";
        echo "<br>Reconstruindo pagamento...";


        $NossoNumero = str_replace("/", "-",$rowOption['NossoNumero']) ;


        $SqlInsereLancamento = "
        INSERT INTO lancamentosbancarios
        (
        `idUsuario`,
        `Valor`,
        `TipoOrigem`,
        `DataBaixa`,
        `idProjeto`,

        `GeradoPor`,
        `BaixadoPor`,
        `idContaReceber`,           

        `Descricao`,
        `idContaBancaria`,
        `DataReferencia`,
        `NumeroDocumento`
        )
        VALUES
        (
        ".$rowOption['idUsuario']." ,
        {$rowOption['Valor']},
        'CR',
        '".$rowOption['DataBaixa']."',
        ".$rowOption['idProjeto']." ,
        ".$rowOption['GeradoPor']." ,
        {$_SESSION['idlogado']},
        ".$rowOption['id']." ,
        'Crédito gerado por boleto bancario online Nosso Nº {$NossoNumero} ',
        1,
        '".$rowOption['DataReferencia']."', '{$NossoNumero}' );";

        echo "####<br>SQL Insert <br>  " . $SqlInsereLancamento."   <br>#######################";

        #Verifica Lancamento
          if(verificaLancamento2(0,$rowOption['DataReferencia'],$rowOption['idUsuario'])){

            echo "<br>User: {$rowOption['idUsuario']} | Valor:{$rowOption['Valor']}  -  Pagamento ok. <br>";

                  if (! $db->query($SqlInsereLancamento) ){
                    echo '<br>:: Erro : '. $db->errorInfo()[2]; 
                    #echo "F: Anote o seguinte erro!";
                  }else{
                    echo "<br>Pagamento ok.<br><br>";
                }

                


          }

      }else{
        
    #Se existir pgamento atualiza a data de Baixa para o lancamento bancario
    $idBoleto          =  $rowOption['id'];
    $DataBaixaBoleto   = $rowOption['DataBaixa'];



    #Update Lancamento Bancario
    $sqlUpdate = "Update lancamentosbancarios SET DataBaixa ='{$DataBaixaBoleto}' WHERE idContaReceber = {$idBoleto} ";

    echo $rowOption['NossoNumero'] . " - ". $sqlUpdate . "<br>";
    

    if (! $db->query($sqlUpdate) ){
      die( ':: Erro : '. $db->errorInfo()[2]); 
      echo "Fase de teste : Anote o seguinte erro! <br>";
    };







      }


}  




?>



                    </div>
                </div>
            


<script type="text/javascript">

    


</script>   





<?php

function verificaLancamento2($fValorCREDITO,$fdata,$idusuario){

      #Debug
       #echo " select count(*) as total from lancamentosbancarios where 
       #      DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
       #      and idUsuario = {$idusuario} ";

            //exit;

    // Realize a conexão com o banco de dados
    $db = DB::getInstance();

    $sqlDel = "select count(*) as total from lancamentosbancarios where 
             DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
             and idUsuario = {$idusuario}";

    echo "<br> {$sqlDel}  ";       
    $rs = $db->query($sqlDel);
    $row= $rs->results(true);
    if($row['total'] > 0){
        echo "total  {$row['total']} - existe<br>";  
        echo "Excluindo fechamentos...<br>";

        //$id = $_GET['id'];  

        #$db->query("DELETE FROM `lancamentosbancarios` WHERE 
        #DataReferencia = '{$fdata}' 
        #and Round(Valor,2) = '{$fValorCREDITO}'
        #and idUsuario = {$idusuario} ") ; 
        
        echo "DELETE FROM `lancamentosbancarios` WHERE 
        DataReferencia = '{$fdata}' 
        and Round(Valor,2) = '{$fValorCREDITO}'
        and idUsuario = {$idusuario} <br>";

        //Redirect("lancamentos-campo.php?id=".$id);
        //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");


        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        echo "Não foi gerada fechamento apara esse boleto...";
        return true;
    }


}


echo "<h1>" . date("Y-m-d H:i:s") . "</h1>";
?>             



