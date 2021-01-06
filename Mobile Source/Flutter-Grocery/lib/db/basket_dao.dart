import 'package:fluttermultigrocery/viewobject/basket.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class BasketDao extends PsDao<Basket> {
  BasketDao._() {
    init(Basket());
  }
  static const String STORE_NAME = 'Basket';
  final String _primaryKey = 'id';

  // Singleton instance
  static final BasketDao _singleton = BasketDao._();

  // Singleton accessor
  static BasketDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(Basket object) {
    return object.id;
  }

  @override
  Filter getFilter(Basket object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
