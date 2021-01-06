import 'package:fluttermultigrocery/viewobject/shop_rating.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class ShopRatingDao extends PsDao<ShopRating> {
  ShopRatingDao._() {
    init(ShopRating());
  }
  static const String STORE_NAME = 'Shop Rating';
  final String _primaryKey = 'id';

  // Singleton instance
  static final ShopRatingDao _singleton = ShopRatingDao._();

  // Singleton accessor
  static ShopRatingDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(ShopRating object) {
    return object.id;
  }

  @override
  Filter getFilter(ShopRating object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
