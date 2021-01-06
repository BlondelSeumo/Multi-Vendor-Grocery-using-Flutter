import 'package:fluttermultigrocery/viewobject/shop_info.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class ShopInfoDao extends PsDao<ShopInfo> {
  ShopInfoDao._() {
    init(ShopInfo());
  }
  static const String STORE_NAME = 'ShopInfo';
  final String _primaryKey = 'id';

  // Singleton instance
  static final ShopInfoDao _singleton = ShopInfoDao._();

  // Singleton accessor
  static ShopInfoDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(ShopInfo object) {
    return object.id;
  }

  @override
  Filter getFilter(ShopInfo object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
