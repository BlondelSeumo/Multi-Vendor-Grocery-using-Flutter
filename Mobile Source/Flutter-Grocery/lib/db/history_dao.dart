import 'package:fluttermultigrocery/viewobject/product.dart';
import 'package:sembast/sembast.dart';
import 'package:fluttermultigrocery/db/common/ps_dao.dart' show PsDao;

class HistoryDao extends PsDao<Product> {
  HistoryDao._() {
    init(Product());
  }
  static const String STORE_NAME = 'History';
  final String _primaryKey = 'id';

  // Singleton instance
  static final HistoryDao _singleton = HistoryDao._();

  // Singleton accessor
  static HistoryDao get instance => _singleton;

  @override
  String getStoreName() {
    return STORE_NAME;
  }

  @override
  String getPrimaryKey(Product object) {
    return object.id;
  }

  @override
  Filter getFilter(Product object) {
    return Filter.equals(_primaryKey, object.id);
  }
}
