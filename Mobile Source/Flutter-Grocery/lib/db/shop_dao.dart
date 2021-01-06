import 'package:fluttermultigrocery/db/common/ps_dao.dart';
import 'package:fluttermultigrocery/viewobject/shop.dart';
import 'package:sembast/sembast.dart';

class ShopDao extends PsDao<Shop> {
  ShopDao._() {
    init(Shop());
  }

  static const String STORE_NAME = 'Shop';
  final String _primaryKey = 'id';
  // Singleton instance
  static final ShopDao _singleton = ShopDao._();

  // Singleton accessor
  static ShopDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(Shop object) {
    return object.id;
  }

  @override
  Filter getFilter(Shop object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
