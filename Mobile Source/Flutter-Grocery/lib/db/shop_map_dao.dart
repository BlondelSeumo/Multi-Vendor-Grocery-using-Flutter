import 'package:fluttermultigrocery/db/common/ps_dao.dart';
import 'package:fluttermultigrocery/viewobject/shop_map.dart';
import 'package:sembast/sembast.dart';

class ShopMapDao extends PsDao<ShopMap> {
  ShopMapDao._() {
    init(ShopMap());
  }
  static const String STORE_NAME = 'ShopMap';
  final String _primaryKey = 'id';

  // Singleton instance
  static final ShopMapDao _singleton = ShopMapDao._();

  // Singleton accessor
  static ShopMapDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(ShopMap object) {
    return object.id;
  }

  @override
  Filter getFilter(ShopMap object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
