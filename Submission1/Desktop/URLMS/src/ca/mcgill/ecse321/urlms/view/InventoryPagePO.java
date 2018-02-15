package ca.mcgill.ecse321.urlms.view;

import java.awt.BorderLayout;
import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.InventoryController;
import ca.mcgill.ecse321.urlms.model.Equipment;
import ca.mcgill.ecse321.urlms.model.InventoryItem;
import ca.mcgill.ecse321.urlms.model.SupplyType;

import javax.swing.JButton;
import javax.swing.JLabel;
import java.util.List;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JScrollPane;
import javax.swing.SwingConstants;

public class InventoryPagePO extends JFrame {

	private JPanel contentPane;
	JLabel inventoryItemListLabel;
	JLabel welcomeToInventoryLabel;
	JLabel feelFreeLabel;

	public static InventoryController controller = new InventoryController();
	public AddInventoryItemPO aiipo = new AddInventoryItemPO();
	public EditInventoryItemPO eiipo = new EditInventoryItemPO();
	private JButton btnAddInventoryItem;
	private JButton btnRemoveItem;
	private JButton btnSave;
	private String error;
	private JButton btnClose;
	private JButton btnViewItemList;

	/**
	 * Create the frame.
	 */
	public InventoryPagePO() {
		initComponents();
	}

	private void initComponents() {
		setTitle("Inventory");
		setResizable(false);
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 535, 300);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		contentPane.setLayout(new BorderLayout(0, 0));

		JPanel panel = new JPanel();
		contentPane.add(panel, BorderLayout.SOUTH);

		btnViewItemList = new JButton("View Item List");
		btnViewItemList.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";

				List<InventoryItem> inventoryList;
				String name;
				int index;
				double cost;
				String category;
				String quantity;
				String type;

				try {
					inventoryList = controller.viewInventoryList();
					inventoryItemListLabel.setText("");
					inventoryItemListLabel.setText("<html>");
					index = 0;

					for (InventoryItem aItem : inventoryList) {
						String previousText = inventoryItemListLabel.getText();
						name = aItem.getName();
						category = aItem.getCategory();
						cost = aItem.getCost();
						quantity = controller.viewSupplyItemQuantity(index);
						if (aItem instanceof SupplyType) {
							type = "Supply";
						} else if (aItem instanceof Equipment) {
							type = "Equipement";
						} else {
							type = "idk man";
						}
						inventoryItemListLabel.setText(previousText + "Item Name: " + name + "&nbsp &nbsp &nbsp "
								+ "Item ID: " + index + "&nbsp &nbsp &nbsp " + "Item Type: " + type + "&nbsp &nbsp &nbsp "
								+ "Item Category: " + category + "&nbsp &nbsp &nbsp " + "Cost: $" + String.format("%.2f", cost)
								+ "&nbsp &nbsp &nbsp " + "Quantity: " + quantity + " <br/>");
						index++;
					}
					String previousText = inventoryItemListLabel.getText();
					inventoryItemListLabel.setText(previousText + "</html>");
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (RuntimeException e1) {
					error += "Error. Please try again. ";
				}
				refreshData();
			}
		});
		panel.add(btnViewItemList);

		btnAddInventoryItem = new JButton("Add Item");
		btnAddInventoryItem.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				aiipo.setVisible(true);
			}
		});
		panel.add(btnAddInventoryItem);

		btnRemoveItem = new JButton("Edit Item");
		btnRemoveItem.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {

				eiipo.setVisible(true);
			}
		});
		panel.add(btnRemoveItem);

		btnSave = new JButton("Save");
		panel.add(btnSave);

		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		panel.add(btnClose);

		JScrollPane scrollPane = new JScrollPane();
		contentPane.add(scrollPane, BorderLayout.CENTER);

		inventoryItemListLabel = new JLabel("");
		inventoryItemListLabel.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setViewportView(inventoryItemListLabel);

		feelFreeLabel = new JLabel("Feel free to do stuff with the inventory.");
		feelFreeLabel.setHorizontalAlignment(SwingConstants.CENTER);
		scrollPane.setColumnHeaderView(feelFreeLabel);

		JPanel panel_1 = new JPanel();
		contentPane.add(panel_1, BorderLayout.NORTH);

		welcomeToInventoryLabel = new JLabel("Welcome to Inventory. There's a lot of inventory.");
		panel_1.add(welcomeToInventoryLabel);
		btnSave.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				controller.save();
				SavePO spo = new SavePO();
				spo.setVisible(true);
			}
		});
	}

	private void refreshData() {
		if (error.length() > 0) {
			feelFreeLabel.setText(error);
		} else {
			feelFreeLabel.setText("Feel free to try adding some inventory items, and then viewing them.");
		}
	}

	public void close() {
		this.setVisible(false);
		this.dispose();
	}
}
